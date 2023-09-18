<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_POST['tourOperatorId'])) {
    $offerDestination = $manager->createOfferDestination($_POST['destinationId'], $_POST['price'], $_POST['tourOperatorId']);
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
