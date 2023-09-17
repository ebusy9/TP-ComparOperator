<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_GET['id'])) {
    $result = (new Manager($db))->deleteOfferDestinationById($_GET['id']);
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