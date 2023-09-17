<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['tourOperatorId'])) {
    $certificate = (new Manager($db))->createCertificate($_POST['tourOperatorId'], $_POST['expiresAt'],  $_POST['signatory']);
    $currentFile = basename($_SERVER['PHP_SELF']);
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
