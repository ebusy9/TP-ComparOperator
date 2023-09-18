<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_POST['destinationName'])) {
    $name = str_replace(" ", "_", strtolower($_POST['destinationName']));
    $uniqueKey = $manager->getUniqueIdForImgUpload();
    $imgUploadError = $_FILES['destinationImg']['error'];

    if ($imgUploadError === UPLOAD_ERR_OK) {
        $isFileImage = exif_imagetype($_FILES['destinationImg']['tmp_name']);
        if ($isFileImage !== false) {
            $fileExtension = pathinfo($_FILES['destinationImg']['name'], PATHINFO_EXTENSION);
            $imgPath = "assets/destination_img/{$name}{$uniqueKey}.{$fileExtension}";
            $imgDestinationPath = "../assets/destination_img/{$name}{$uniqueKey}.{$fileExtension}";
            move_uploaded_file($_FILES['destinationImg']['tmp_name'], $imgDestinationPath);
        } else {
            header("Location:../manage_destinations.php?redirectedFrom={$currentFile}&info=fileExtentionNotSupported");
            die();
        }
    } elseif ($imgUploadError !== UPLOAD_ERR_OK) {
        $errorCode = $_FILES['uploadPicture']['error'];
        $phpFileUploadErrors = [
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        ];
        if (isset($phpFileUploadErrors[$errorCode])) {
            $_SESSION['uploadPicture'] = $phpFileUploadErrors[$errorCode];
            header("Location:../manage_destinations.php?name={$currentFile}&info=uploadFailed");
            die();
        } else {
            $_SESSION['uploadPicture'] = "Unknown Error";
            header("Location:../manage_destinations.php?name={$currentFile}&info=uploadFailedUnknownError");
            die();
        }
    }

    $destination = $manager->createDestination($_POST['destinationName'], $imgPath);

    if ($destination) {
        header("Location:../manage_destinations.php?redirectedFrom={$currentFile}&info=createDestinationSuccess");
        die();
    } else {
        header("Location:../manage_destinations.php?redirectedFrom={$currentFile}&info=createDestinationFailed");
        die();
    }
} else {
    header("Location:../manage_destinations.php?redirectedFrom={$currentFile}&info=destinationNameIsNotSet");
    die();
}