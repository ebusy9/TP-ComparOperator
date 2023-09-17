<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['tourOperatorId'])) {
    $offerDestination = (new Manager($db))->createOfferDestination($_POST['destinationId'], $_POST['price'], $_POST['tourOperatorId']);
    if ($offerDestination) {
        header("Location:../manage_offers.php?tourOperatorId={$_POST['tourOperatorId']}&info=addOfferSuccess");
        die();
    } else {
        header("Location:../manage_offers.php?tourOperatorId={$_POST['tourOperatorId']}&info=addOfferFailed");
        die();
    }
} else {
    header("Location:../manage_offers.php?redirectedFrom={$currentFile}&info=TourOperatorIdIdIsNotSet");
    die();
}
