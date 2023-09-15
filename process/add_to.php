<?php

use class\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['name'])) {
    $manager = new Manager($db);
    $currentFile = __FILE__;

    $name = str_replace(" ", "_", strtolower($_POST['name']));
    $uniqueKey = $manager->getUniqueIdForImgUpload();
    $imgUploadError = $_FILES['img']['error'];

    if ($imgUploadError === UPLOAD_ERR_OK) {
        $isFileImage = exif_imagetype($_FILES['img']['tmp_name']);
        if ($isFileImage !== false) {
            $fileExtension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $imgPath = "assets/to_logo/{$name}{$uniqueKey}.{$fileExtension}";
            $imgDestinationPath = "../assets/to_logo/{$name}{$uniqueKey}.{$fileExtension}";
            move_uploaded_file($_FILES['img']['tmp_name'], $imgDestinationPath);
        } else {
            header('Location:../admin.php?redirectedFrom={$currentFile}&info=fileExtentionNotSupported');
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
            die();
        } else {
            $_SESSION['uploadPicture'] = "Unknown Error";
            die();
        }
    }

    $review = $manager->createTourOperator($_POST['name'], $_POST['link'], $imgPath);

    if ($review) {
        header("Location:../admin.php?name={$_POST['locationName']}&info=createTourOperatorSuccess");
        die();
    } else {
        header('Location:../admin.php?redirectedFrom={$currentFile}&info=createTourOperatorFailed');
        die();
    }
} else {
    header('Location:../admin.php?redirectedFrom={$currentFile}&info=nameIsNotSet');
    die();
}
