<?php

use class\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php"; 




if (isset($_POST['pseudo'])){
    $manager = new Manager($db);
    $name = ucfirst($_POST['pseudo']);
    $score = $_POST['score'];
    $nameDestination = $_POST['nameDestination'];
    $tourOperatorId = $_POST['tourOperatorId'];
    $message = $_POST['message'];
    $manager->CreateReview($name, $score, $tourOperatorId, $message);
}
header('Location:../destination.php?name='. $nameDestination);


