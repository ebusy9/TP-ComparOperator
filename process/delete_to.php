<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_GET['id'])) {
    $imgPathForUnlink = "../" . ((new Manager($db))->readTourOperatorById($_GET['id']))->getTourOperatorImg();
    $result = (new Manager($db))->deleteTourOperatorById($_GET['id']);
    $currentFile = basename($_SERVER['PHP_SELF']);
    if ($result) {
        unlink($imgPathForUnlink);
        header("Location:../admin.php?name={$currentFile}&info=delteTOSuccess");
        die();
    } else {
        header("Location:../admin.php?redirectedFrom={$currentFile}&info=delteTOFailed");
        die();
    }
} else {
    header("Location:../admin.php?redirectedFrom={$currentFile}&info=idIsNotSet");
    die();
}