<?php

use class\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);

if (isset($_GET['id'])) {
    $result = (new Manager($db))->deleteTourOperatorById($_GET['id']);
    $currentFile = __FILE__;
    if ($result) {
        header("Location:../admin.php?name={$currentFile}&info=delteTOSuccess");
        die();
    } else {
        header('Location:../admin.php?redirectedFrom={$currentFile}&info=delteTOFailed');
        die();
    }
} else {
    header('Location:../admin.php?redirectedFrom={$currentFile}&info=idIsNotSet');
    die();
}