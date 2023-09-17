<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();

if (isset($_POST['tourOperatorId'])) {
    $certificate = $manager->createCertificate($_POST['tourOperatorId'], $_POST['expiresAt'],  $_POST['signatory']);
    if ($certificate) {
        header("Location:../admin.php?tourOperatorId={$_POST['tourOperatorId']}&info=addCertificateSuccess");
        die();
    } else {
        header("Location:../admin.php?tourOperatorId={$_POST['tourOperatorId']}&info=addCertificateFailed");
        die();
    }
} else {
    header("Location:../admin.php?redirectedFrom={$currentFile}&info=TourOperatorIdIdIsNotSet");
    die();
}
