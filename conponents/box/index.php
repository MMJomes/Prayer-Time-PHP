<?php
// Show PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

include '../../classes/box.php';

$objBox = new Box();

// GET
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        if ($id != null) {
            if ($objBox->delete($id)) {
                $objBox->redirect('index.php?deleted');
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
                <div class="row" style="display: flex; align-items: center;">
                    <div class="col-md-6">
                        <h2 style="margin-top: 10px; margin-bottom: 0;">Boxes </h2>
                    </div>
                    <div class="col-md-6 text-right mt-3">
                        <a href="/conponents/box/create.php" class="btn btn-primary"><span
                                data-feather="plus-circle"></span> Add new Box</a>
                    </div>
                </div>
                <br>
                <?php
                session_start();
                if (isset($_GET['updated']) && !isset($_SESSION['alert_displayed'])) {
                    $_SESSION['alert_displayed'] = true;
                    echo '<div id="updatedAlert" class="alert alert-info alert-dismissible fade show" role="alert">
                                    <strong>Box!</strong> Updated with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                } else if (isset($_GET['deleted']) && !isset($_SESSION['alert_displayed'])) {
                    $_SESSION['alert_displayed'] = true;
                    echo '<div id="deletedAlert" class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Box!</strong> Deleted with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                } else if (isset($_GET['inserted']) && !isset($_SESSION['alert_displayed'])) {
                    $_SESSION['alert_displayed'] = true;
                    echo '<div id="insertedAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Box!</strong> Inserted with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                } else if (isset($_GET['error']) && !isset($_SESSION['alert_displayed'])) {
                    $_SESSION['alert_displayed'] = true;
                    echo '<div id="errorAlert"  class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>DB Error!</strong> Something goes wrong during the database transaction. Try again!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                }

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>PrayerZone</th>
                                <th>Subscriber Name</th>
                                <th>Box Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $query = "SELECT b.id, b.prayerzone, s.name AS subscriber_name, b.name AS box_name 
          FROM boxs b 
          JOIN subscribers s ON b.subscriber_id = s.id";
                        $stmt = $objBox->runQuery($query);
                        $stmt->execute();
                        ?>
                        <tbody>
                            <?php if ($stmt->rowCount() > 0) {
                                $no = 1;
                                while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td>
                                            <?php print ($no++); ?>
                                        </td>
                                        <td>
                                            <?php print ($rowUser['prayerzone']); ?>
                                        </td>
                                        <td>
                                            <?php print ($rowUser['subscriber_name']); ?>
                                        </td>
                                        <td>
                                            <?php print ($rowUser['box_name']); ?>
                                        </td>
                                        <td>
                                            <a class="confirmation"
                                                href="/conponents/box/index.php?delete_id=<?php print ($rowUser['id']); ?>">
                                                <span data-feather="trash" style="color: red;"></span>
                                            </a>
                                            <a href="/conponents/box/create.php?edit_id=<?php print ($rowUser['id']); ?>">
                                                <span data-feather="edit" style="color: blue;margin-left: 5px;"></span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5" style="text-align: center">No record found...</td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </main>
        </div>
    </div>
    <!-- Footer scripts, and functions -->
    <?php require_once '../../includes/footer.php'; ?>
    <?php require_once '../../includes/confrimation.php'; ?>
</body>

</html>