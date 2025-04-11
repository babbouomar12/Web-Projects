<?php
include 'components/header.php';
include 'components/footer.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    
        <div class="card p-4 shadow" style="min-width: 350px;">
            <h3 class="text-center mb-4">Login</h3>
            
            <?php
                require_once "Classes/ConnectionDB.php";
                require_once "Classes/SessionManagerClass.php";

                $sess = new SessionManager();
                $SessionID = $sess->getValueByKey("SuccessfulLogin");
                if (isset($SessionID)) {
                    header("Location: home.php");
                    exit();
                }

                $usernameOrEmail = "";
                $password = "";
                $error = "";

                if (isset($_POST["submit"])) {
                    $passFound = false;
                    $userFound = false;
                    if (isset($_POST["usernameEmail"])) {
                        $usernameOrEmail = $_POST["usernameEmail"];
                        $userFound = true;
                    }
                    if (isset($_POST["password"])) {
                        $password = $_POST["password"];
                        $passFound = true;
                    }
                    if ($passFound && $userFound) {
                        $pdo = ConnectionDB::getInstance();
                        $stmt = $pdo->prepare("
                            SELECT * FROM User WHERE
                            (username = :usernameEmail OR
                            email = :usernameEmail)
                        ");
                        $stmt->execute([
                            ':usernameEmail' => $usernameOrEmail
                        ]);
                    
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($user && password_verify($password, $user['password'])) {
                            if ($user['role'] == "Admin") {
                                $sess->addItemToSession("AdminAuth", $_COOKIE['PHPSESSID']);
                            }
                            $sess->addItemToSession("user", $user);
                            $sess->addItemToSession("SuccessfulLogin", $_COOKIE['PHPSESSID']);
                            header("Location: home.php");
                            exit();
                        } else {
                            echo '
                            <div class="alert alert-danger text-center d-flex justify-content-center align-items-center p-4" role="alert">
                                <img src="./assets/exclamation-triangle.svg" class="img-fluid mr-3" alt="Error" style="width: 30px; height: 30px">
                                <span>Email ou mot de passe incorrect.</span>
                            </div>
                            ';

                        }
                    }
                }
            ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="usernameEmail">Nom d'utilisateur / Email</label>
                    <input type="text" class="form-control" id="usernameEmail" name="usernameEmail" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>