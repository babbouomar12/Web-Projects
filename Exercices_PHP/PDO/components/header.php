<?php
require_once __DIR__."/../Classes/SessionManagerClass.php";

$sess = new SessionManager();
$sesssionID = isset($_SESSION['SuccessfulLogin']) ? $_SESSION['SuccessfulLogin'] : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Students Management System</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/home.php">Students Management System</a>
    <?php if(isset($sesssionID)): ?>
    
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="/home.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/Lists/StudentsList.php">Liste des Etudiants</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/Lists/SectionsList.php">Liste des Sections</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/logout.php">Logout</a>
            </li>
        </ul>
        </div>
    <?php endif; ?>
    </nav>