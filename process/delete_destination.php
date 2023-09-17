<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_GET['id'])) {
    $imgPathForUnlink = "../" . ((new Manager($db))->readDestinationById($_GET['id']))->getDestinationImg();
    $result = (new Manager($db))->deleteDestinationById($_GET['id']);
    $currentFile = basename($_SERVER['PHP_SELF']);
    if ($result) {
        unlink($imgPathForUnlink);
        header("Location:../manage_destinations.php?name={$currentFile}&info=delteDestinationSuccess");
        die();
    } else {
        header("Location:../manage_destinations.php?redirectedFrom={$currentFile}&info=delteDestinationFailed");
        die();
    }
} else {
    header("Location:../manage_destinations.php?redirectedFrom={$currentFile}&info=idIsNotSet");
    die();
}