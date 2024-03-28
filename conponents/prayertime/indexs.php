<!doctype html>
<html lang="en">

<head>
    <?php require_once '../../includes/head.php'; ?>
</head>

<body>
    <?php require_once '../../includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once '../../includes/sidebar.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="row" style="display: flex; align-items: center;">
                    <div class="col-md-6">
                        <h5 style="margin-top: 10px; margin-bottom: 0;">Prayer Time Details</h5>
                    </div>
                </div>
                <br>
                <div class="table table-bordered DataTable table-hover table-striped table-condensed btn">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Tarikh Miladi</th>
                                <th>Tarikh Hijri</th>
                                <th>Hari</th>
                                <th>Imsak</th>
                                <th>Subuh</th>
                                <th>Syuruk</th>
                                <th>Zohor</th>
                                <th>Asar</th>
                                <th>Maghrib</th>
                                <th>Isyak</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            ini_set('display_errors', 1);
                            ini_set('display_startup_erros', 1);
                            error_reporting(E_ALL);
                            include '../../classes/song.php';
                            session_start();
                            $objSong = new Song();
                            function retrievePrayerTimes($zone)
                            {
                                try {
                                    $my_url = "https://www.e-solat.gov.my/index.php?r=esolatApi/TakwimSolat&period=week&zone={$zone}";
                                    $response = file_get_contents($my_url);
                                    if ($response !== false) {
                                        $prayerTimes = $response;
                                        return $prayerTimes;
                                    } else {
                                        echo 'Failed to retrieve prayer times.';
                                        return false;
                                    }
                                } catch (Exception $e) {
                                    echo 'Exception occurred: ' . $e->getMessage();
                                    return false; // Return false on exception
                                }
                            }

                            function isPrayerDate($prayerDate)
                            {
                                return $prayerDate === date('Y-m-d');
                            }

                            $query = "SELECT s.*,  sb.name AS subscriber_name, b.name AS box_name 
                            FROM songs s 
                            JOIN boxs b ON s.box_id = b.id 
                            JOIN subscribers sb ON b.subscriber_id = sb.id";
                            $stmt = $objSong->runQuery($query);
                            $stmt->execute();
                            $songs = $stmt->fetchAll(PDO::FETCH_OBJ);
                            if (!isset($_SESSION['detail_data'])) {
                                $_SESSION['detail_data'] = [];
                            }
                            foreach ($songs as $song) {
                                if (isPrayerDate($song->prayertimedate)) {
                                    if (date('H:i', strtotime($song->prayertime)) !== date('H:i')) {
                                        $prayerTimes = retrievePrayerTimes($song->prayerzone);
                                        $prayerTimes = json_decode($prayerTimes, true);
                                        $zone = $prayerTimes['zone'];
                                        $prayerTimes = $prayerTimes['prayerTime'];
                                        foreach ($prayerTimes as $index => $innerArray) {
                                            $_SESSION['detail_data'][] = [
                                                'date' => $innerArray['date'],
                                                'zone' => $zone,
                                                'name' => $innerArray,
                                            ];                               
                                            echo '<tr>';
                                            echo '<td>' . $innerArray['date'] . ' </td>';
                                            echo '<td>' . $innerArray['hijri'] . ' </td>';
                                            echo '<td>' . $innerArray['day'] . ' </td>';
                                            echo '<td>' . $innerArray['imsak'] . ' </td>';
                                            echo '<td>' . $innerArray['fajr'] . ' </td>';
                                            echo '<td>' . $innerArray['syuruk'] . ' </td>';
                                            echo '<td>' . $innerArray['dhuhr'] . ' </td>';
                                            echo '<td>' . $innerArray['asr'] . ' </td>';
                                            echo '<td>' . $innerArray['maghrib'] . ' </td>';
                                            echo '<td>' . $innerArray['isha'] . ' </td>';
                                            echo '<td><a href="/conponents/prayertime/detail.php?id=' . $index . '" class="btn btn-outline-primary btn-sm btn-block">Detail</a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                }
                            }
                            session_write_close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <!-- Footer scripts, and functions -->
    <?php require_once '../../includes/footer.php'; ?>
</body>

</html>