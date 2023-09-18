<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_GET['id'])) {
    $result = $manager->deleteOfferDestinationById($_GET['id']);
    if ($result) {
        header("Location:../manage_offers.php?redirectedFrom={$currentFile}&info=delteOfferSuccess");
        die();
    } else {
        header("Location:../manage_offers.php?redirectedFrom={$currentFile}&info=delteOfferFailed");
        die();
    }
} else {
    header("Location:../manage_offers.php?redirectedFrom={$currentFile}&info=idIsNotSet");
    die();
}