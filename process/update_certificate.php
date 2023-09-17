<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();

if (isset($_POST['tourOperatorId'])) {
    $certificate = $manager->readCertificateByTourOperatorId($_POST['tourOperatorId']);
    $certificate->setExpiresAt($_POST['expiresAt']);
    $certificate->setSignatory($_POST['signatory']);

    $result = $manager->updateCertificate($certificate);

    if ($result) {
        header("Location:../admin.php?tourOperatorId={$_POST['tourOperatorId']}&info=updateCertificateSuccess");
        die();
    } else {
        header("Location:../admin.php?tourOperatorId={$_POST['tourOperatorId']}&info=updateCertificateFailed");
        die();
    }
} else {
    header("Location:../admin.php?redirectedFrom={$currentFile}&info=TourOperatorIdIdIsNotSet");
    die();
}
