<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_POST['offerDestinationId'])) {
    $offerDestination = $manager->readOfferDestinationById($_POST['offerDestinationId']);
    $offerDestination->setPrice($_POST['price']);
    $offerDestination->setTourOperatorId($_POST['tourOperatorId']);
    $offerDestination->setDestinationId($_POST['destinationId']);

    $result = $manager->updateOfferDestination($offerDestination);
    if ($result) {
        header("Location:../manage_offers.php?offerDestinationId={$_POST['offerDestinationId']}&info=updateofferSuccess");
        die();
    } else {
        header("Location:../manage_offers.php?offerDestinationId={$_POST['offerDestinationId']}&info=updateofferFailed");
        die();
    }
} else {
    header("Location:../manage_offers.php?redirectedFrom={$currentFile}&info=offerDestinationIdIsNotSet");
    die();
}
