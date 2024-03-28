<?php
// Show PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once '../../classes/subscriber.php';

$obSubscriber = new Subscriber();

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt = $obSubscriber->runQuery("SELECT * FROM subscribers WHERE id=:id");
    $stmt->execute(array(":id" => $id));
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $rowUser = null;
}

if (isset($_POST['btn_save'])) {
    $name = strip_tags($_POST['name']);
    try {
        if ($id != null) {
            if ($obSubscriber->update($name, $id)) {
                $obSubscriber->redirect('/conponents/subscribers/index.php?updated');
            } else {
                $obSubscriber->redirect('/conponents/subscribers/index.php?error');
            }
        } else {
            if ($obSubscriber->insert($name)) {
                $obSubscriber->redirect('/conponents/subscribers/index.php?inserted');
            } else {
                $obSubscriber->redirect('/conponents/subscribers/index.php?error');
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
                <h3 style="margin-top: 10px">Subscriber Info:</h3>
                <p>Required fields are in (*).</p>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php isset($rowUser['name']) ? print ($rowUser['name']) : '{{ old("name") }}' ?>"
                                    placeholder="First and last name" required maxlength="100">
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