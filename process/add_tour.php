<?php

use class\Manager;
use class\TourOperator;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php"; 

$dbManager = new Manager($db);


$author = 1;
$operatorId =2; 

$dbManager = new Manager($db);
$ReviewData = new Review();
$ReviewData->hydrate([
    "author" => $author,
    "message" =>$_POST["message"],
    "operatorId" => $operatorId,
]);

$dbManager->createReview($ReviewData);

header('Location: ../admin.php');
exit;