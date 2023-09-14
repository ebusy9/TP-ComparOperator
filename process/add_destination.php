<?php

use class\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$OperatorId = 1;
$location = "location";
$price = 1;

$dbManager = new Manager($db);



header('Location: ../admin.php');
exit;
