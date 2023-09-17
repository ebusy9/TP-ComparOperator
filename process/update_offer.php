<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['offerDestinationId'])) {
    $manager = new Manager($db);
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
