<?php

$data = json_decode($json);

use class\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php"; 

$manager = new Manager($db);

if (isset($_GET['id'])) {
    $review = (new Manager($db))->deleteDestinationByOperatorId($_GET['id']);
    $currentFile = __FILE__;
    if ($review) {
        header("Location:../admin.php?name={$_POST['locationName']}&info=delteTOSuccess");
        die();
    } else {
        header('Location:../admin.php?redirectedFrom={$currentFile}&info=delteTOFailed');
        die();
    }
} else {
    header('Location:../admin.php?redirectedFrom={$currentFile}&info=idIsNotSet');
    die();
}