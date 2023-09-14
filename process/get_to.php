<?php

use class\Manager;


include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php"; 



$dbManager = new Manager($db);

$allOperators = $dbManager->getAllTourOperator();

echo json_encode($allOperators);