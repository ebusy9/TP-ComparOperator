<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_GET['id'])) {
    $result = (new Manager($db))->deleteCertificateByTourOperatorId($_GET['id']);
    if ($result) {
        header("Location:../admin.php?name={$currentFile}&info=delteCertificateSuccess");
        die();
    } else {
        header("Location:../admin.php?redirectedFrom={$currentFile}&info=delteCertificateFailed");
        die();
    }
} else {
    header("Location:../admin.php?redirectedFrom={$currentFile}&info=idIsNotSet");
    die();
}