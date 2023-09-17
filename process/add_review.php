<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['destinationId'])) {
    $review = (new Manager($db))->publishReview($_POST['authorName'], $_POST['tourOperatorId'],  $_POST['score'], $_POST['message']);
    $currentFile = basename($_SERVER['PHP_SELF']);
    if ($review) {
        header("Location:../tour.php?destinationId={$_POST['destinationId']}&info=addReviewSuccess");
        die();
    } else {
        header("Location:../tour.php?destinationId={$_POST['destinationId']}&info=addReviewFailed");
        die();
    }
} else {
    header("Location:../location.php?redirectedFrom={$currentFile}&info=destinationIdIsNotSet");
    die();
}
