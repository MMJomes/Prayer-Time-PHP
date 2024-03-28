<?php
// Show PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once '../../classes/song.php';

$objSong = new Song();

// GET
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt = $objSong->runQuery("SELECT * FROM songs WHERE id=:id");
    $stmt->execute(array(":id" => $id));
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $rowUser = null;
}

// Fetch subscribers data
$stmtSubscribers = $objSong->runQuery("SELECT id, name FROM subscribers");
$stmtSubscribers->execute();
$subscribers = $stmtSubscribers->fetchAll(PDO::FETCH_ASSOC);

// Fetch boxs data
$stmtBoxs = $objSong->runQuery("SELECT id, name FROM boxs");
$stmtBoxs->execute();
$boxes = $stmtBoxs->fetchAll(PDO::FETCH_ASSOC);

// POST
if (isset($_POST['btn_save'])) {
    $name = strip_tags($_POST['name']);
    $prayerzone = strip_tags($_POST['prayerzone']);
    $subscriber_id = $_POST['subscriber_id'];
    $box_id = $_POST['box_id'];
    $prayertimedate = $_POST['prayertimedate'];
    $prayertimeseq = $_POST['prayertimeseq'];
    $prayertime = $_POST['prayertime'];
    try {
        if ($id != null) {
            if ($objSong->update($name, $subscriber_id, $box_id, $prayerzone, $prayertimedate, $prayertimeseq, $prayertime, $id)) {
                $objSong->redirect('/conponents/song/index.php?updated');
            } else {
                $objSong->redirect('/conponents/song/index.php?error');
            }
        } else {
            if ($objSong->insert($name, $subscriber_id, $box_id, $prayerzone, $prayertimedate, $prayertimeseq, $prayertime)) {
                $objSong->redirect('/conponents/song/index.php?inserted');
            } else {
                $objSong->redirect('/conponents/song/index.php?error');
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
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
                <h3 style="margin-top: 10px">Songs Info:</h3>
                <p>Required fields are in (*).</p>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php isset($rowUser['name']) ? print ($rowUser['name']) : '{{ old("name") }}' ?>"
                                    placeholder="First and last name" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subscriber_id">Subscriber Name *</label>
                                <select class="form-control" id="subscriber_id" name="subscriber_id" required>
                                    <option value="">Select Subscriber</option>
                                    <?php foreach ($subscribers as $subscriber) { ?>
                                        <option value="<?php echo $subscriber['id']; ?>" <?php echo isset($rowUser['subscriber_id']) && $rowUser['subscriber_id'] == $subscriber['id'] ? 'selected' : ''; ?>>
                                            <?php echo $subscriber['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="box_id">Box Name *</label>
                                <select class="form-control" id="box_id" name="box_id" required>
                                    <option value="">Select Box</option>
                                    <?php foreach ($boxes as $box) { ?>
                                        <option value="<?php echo $box['id']; ?>" <?php echo isset($rowUser['box_id']) && $rowUser['box_id'] == $box['id'] ? 'selected' : ''; ?>>
                                            <?php echo $box['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prayerzone">PrayerZone *</label>
                                <input type="text" class="form-control" id="prayerzone" name="prayerzone"
                                    value="<?php isset($rowUser['prayerzone']) ? print ($rowUser['prayerzone']) : '{{ old("prayerzone") }}' ?>"
                                    placeholder="Enter PrayerZone" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prayertimedate">PrayerTimeDate *</label>
                                <input type="date" class="form-control" id="prayertimedate" name="prayertimedate"
                                    value="<?php isset($rowUser['prayertimedate']) ? print ($rowUser['prayertimedate']) : '{{ old("prayertimedate") }}' ?>"
                                    placeholder="Enter PrayerTimeDate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prayertimeseq">PrayerTimeSeq *</label>
                                <input type="number" class="form-control" id="prayertimeseq" name="prayertimeseq"
                                    min="1"
                                    value="<?php isset($rowUser['prayertimeseq']) ? print ($rowUser['prayertimeseq']) : '{{ old("prayertimeseq") }}' ?>"
                                    placeholder="Enter PrayerTimeSeq" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="songurl">Prayer Time *</label>
                                <input type="time" class="form-control" id="prayertime" name="prayertime"
                                    value="<?php isset($rowUser['prayertime']) ? print ($rowUser['prayertime']) : '{{ old("prayertime") }}' ?>"
                                    placeholder="Enter Prayer Time" required>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="btn_save" class="btn btn-primary mb-2" value="Save"
                        style="margin-right: 20px">
                    <input type="button" name="btn_back" class="btn btn-secondary mb-2" value="Back"
                        onclick="history.back()">
                </form>
            </main>
        </div>
    </div>
    <?php require_once '../../includes/footer.php'; ?>
</body>

</html>