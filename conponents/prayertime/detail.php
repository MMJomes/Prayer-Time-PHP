<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../classes/song.php';
$objSong = new Song();
$itemIndex = $_GET['id'] ?? null;
if ($itemIndex !== null && isset($_SESSION['detail_data'][$itemIndex])) {
    $detailData = $_SESSION['detail_data'][$itemIndex];
    $zone = $detailData['zone'];
    $date = $detailData['date'];
    if (isset($detailData['name'])) {
        $name = $detailData['name'];
    } else {
        echo "Name is not set for this entry";
    }
} else {
    echo "Invalid item index";
}
session_write_close();
?>
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
                    <div class="col-md-12">
                        <h2 style="margin-top: 10px; margin-bottom: 0;">Prayer Time Details</h2>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Song Detail</h5>
                        <?php
                        $keysToLoop = ['imsak', 'fajr', 'syuruk', 'dhuhr', 'asr', 'maghrib', 'isha'];
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                foreach ($name as $key => $value) {
                                    if (in_array($key, $keysToLoop)) {
                                        ?>
                                        <div class="col-md-4" style="margin-bottom: 20px;">
                                            <div class="card" style="width: 100% !important; height: 10rem !important;">
                                                <div class="card-body">
                                                    <h5 class="card-title" style="text-transform: uppercase;">
                                                        <?php echo ucfirst($key); ?>
                                                    </h5>
                                                    <p class="card-text">
                                                        <span data-feather="clock"
                                                            style="margin-right: 8px;font-weight: bold"></span>
                                                        <?php echo $value; ?>
                                                    </p>
                                                    <?php
                                                    $query = "SELECT s.*, sb.name AS subscriber_name, b.name AS box_name 
                                                                    FROM songs s 
                                                                    JOIN boxs b ON s.box_id = b.id 
                                                                    JOIN subscribers sb ON b.subscriber_id = sb.id 
                                                                    WHERE s.prayerzone = :zone";
                                                    try {
                                                        $stmt = $objSong->runQuery($query);
                                                        $stmt->bindParam(':zone', $zone, PDO::PARAM_STR);
                                                        $stmt->execute();
                                                        $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($songs as $song) {
                                                            $innerTime = date('H:i:s', strtotime($name[$key]));
                                                            $songTime = date('H:i:s', strtotime($song['prayertime']));
                                                            if ($innerTime == $songTime) {
                                                                ?>
                                                                <h5 class="card-subtitle bold"
                                                                    style="font-size: 13px !important; text-align: left;font-weight: bold;">
                                                                    <span data-feather="music"
                                                                        style="margin-right: 8px;font-weight: bold"></span>
                                                                    <?php echo $song['name'] ? ucfirst($song['name']) : '-'; ?>
                                                                </h5>
                                                                <h5 class="card-subtitle bold"
                                                                    style="font-size: 13px !important; margin-top: 14px !important; text-align: left;font-weight: bold;">
                                                                    <span data-feather="play"
                                                                        style="margin-right: 8px;font-weight: bold"></span>
                                                                    <?php echo $song['prayertimeseq'] ? ucfirst($song['prayertimeseq']) : '-'; ?>
                                                                </h5>
                                                                <?php
                                                            }
                                                        }
                                                    } catch (PDOException $e) {
                                                        echo "Error: " . $e->getMessage();
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php require_once '../../includes/footer.php'; ?>
</body>

</html>