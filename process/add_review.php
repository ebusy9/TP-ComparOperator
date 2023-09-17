<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();

if (isset($_POST['authorId'])) {
    $review = $manager->createReview($_POST['message'], $_POST['score'], $_POST['tourOperatorId'], $_POST['authorId']);
    if ($review) {
        header("Location:../manage_reviews.php?authorId={$_POST['authorId']}&info=addReviewSuccess");
        die();
    } else {
        header("Location:../manage_reviews.php?authorId={$_POST['authorId']}&info=addReviewFailed");
        die();
    }
} else {
    header("Location:../manage_reviews.php?redirectedFrom={$currentFile}&info=authorIdIdIsNotSet");
    die();
}