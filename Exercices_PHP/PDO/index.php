
<?php
include_once "autoload.php"; 
$bdd= ConnexionBD::getInstance();
$query="select * from students";
$response=$bdd->query($query);
$students=$response->fetchAll(PDO::FETCH_OBJ); //tableau associatif contenant les infos des etudiants
//var_dump($students);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootswatch/dist/Lux/bootstrap.css">
    <title>Students</title>
</head>
<body>
    <table class="table table-striped">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Infos</th>
        </tr>
        
        <?php foreach($students as $student) { ?>
       
        <tr>
            <td><?= $student->student_id  ?></td>
            <td> <?= $student->student_name?></td>
            <td> <?= $student->student_birthday?></td>
            <td>
            <a href="detailEtudiant.php?id=<?= $student->student_id ?>"> <img style="width:30px ; height:30px" src="icons\info-circle-svgrepo-com (1).svg" alt="infos"></a>
            </td>
        </tr>
    
       
        <?php } ?>


    </table>


    
</body>
</html>



 
