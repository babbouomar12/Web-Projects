
<?php
 include_once "autoload.php"; 


if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Check if 'id' is set in url
    $id = intval($_GET['id']);
   
    $bdd= ConnexionBD::getInstance();

    $stmt = $bdd->prepare("SELECT * FROM students WHERE student_id = :id"); //requete securisee
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); //empeche injection SQL
    $stmt->execute();
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$etudiant) {
        die("Étudiant non trouvé.");
    }
    } else {
    die("ID invalide.");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootswatch/dist/Lux/bootstrap.css">
    <title>Students Details</title>
</head>
<body>
<div class="card text-center">
  <div class="card-header">
  Student Details
  </div>
  <div class="card-body">
    <p class="card-text">Student Name:</strong> <?= htmlspecialchars($etudiant['student_name']) . "<br>" ?></p>
    <p class="card-text">Student Birthday:</strong> <?= htmlspecialchars($etudiant['student_birthday']) . "<br>" ?></p>
    <p class="card-text">Filière:</strong> <?= htmlspecialchars($etudiant['filiere']) ?></p> 
  
    
    
    <a href="index.php" class="btn btn-info">Student list</a>
  </div>
</div>


    

</body>
</html>