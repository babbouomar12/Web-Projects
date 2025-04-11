<?php 

include 'components/header.php';
include 'components/footer.php';
require_once "Classes/SessionManagerClass.php";

$sess = new SessionManager();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <?php
        require_once "Classes/ConnectionDB.php";
        require_once "Classes/SessionManagerClass.php";

        $sess = new SessionManager();
        $SessionID = $sess->getValueByKey("SuccessfulLogin");
        if(isset($SessionID)){
            echo '
                <div id="wlcm" class="alert alert-info text-center shadow-sm p-4 mt-5 mx-auto" style="max-width: 600px; border-radius: 10px;">
                    <h4 class="display-4">Hello, PHP LOVERS!</h4>
                    <p class="lead">Welcome to your <strong>Administration Platform</strong>!</p>
                </div>
            
            ';
        }else{
            header("Location: index.php");
            exit();
        }
    ?>


</body>
</html>