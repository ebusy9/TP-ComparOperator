<?php

use class\Manager;
use class\Destination;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php"; 

$OperatorId = 1;
$location = "location";
$price = 1;

$dbManager = new Manager($db);
$DestinationData = new Destination ();

$DestinationData->hydrate([
    "tour_operator_id" => $OperatorId,
    "location" =>$_POST["location"],
    "price" => $_POST["price"],
]);

$dbManager->createDestination($DestinationData);

header('Location: ../admin.php');
exit;
