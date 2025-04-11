<?php

require_once "../Classes/ConnectionDB.php";
require_once "../Classes/UserClass.php";
require_once "../Classes/StudentClass.php";
require_once "../Classes/SectionClass.php";


$stud1 = new Student(null, "john doe", "2000-02-05", 1, "./path", "john.doe", "john.doe@fake.com", "aze123");

$usr2 = new User("jane.smith", "qwe456", "jane.smith@fake.com", "Admin");

$stud3 = new Student(null, "michael brown", "1999-01-01", 2, "./path", "michael.brown", "michael.brown@fake.com", "zxc789");

$usr4 = new User("aymen.sellaouti", "sdf123", "aymen.sellaouti@fake.com", "Admin");

$stud5 = new Student(null, "david wilson", "2002-08-08", 1, "./path", "david.wilson", "david.wilson@fake.com", "fgh654");

$gl = new Sections("GL", "Genie Logiciel");
$rt = new Sections("RT", "Resaux");

$secs = [$gl, $rt];
$usrs = [$usr2, $usr4];
$studs = [$stud1, $stud3, $stud5];

foreach($secs as $sec) {
    Sections::insertIntoDB($sec);  
}
foreach($usrs as $usr) {
    User::insertUserIntoDB($usr);  
}

foreach($studs as $stud){
    Student::insertIntoDB($stud);
}

?>