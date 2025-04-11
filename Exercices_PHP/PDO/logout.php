<?php
include 'components/header.php';
include 'components/footer.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Logout Confirmation</title>
</head>
<body>

    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 shadow-sm">
            <h4 class="mb-3">Confirm Logout</h4>
            <form action="" method="post" class="text-center">
                <p>Are you sure you want to logout?</p>
                <div class="d-flex justify-content-around mt-3">
                    <button type="submit" name="confirm" value="yes" class="btn btn-danger">Yes</button>
                    <button type="submit" name="confirm" value="no" class="btn btn-secondary">No</button>
                </div>
            </form>
        </div>
    </div>

    <?php
        require_once "Classes/SessionManagerClass.php";

        $sess = new SessionManager();

        if (isset($_POST['confirm'])) {
            if ($_POST['confirm'] === 'yes') {
                $sess->destroySession();
                header('Location: ./index.php');
                exit();
            } elseif ($_POST['confirm'] === 'no') {
                header('Location: ./home.php');
                exit();
            }
        }
    ?>

</body>
</html>
