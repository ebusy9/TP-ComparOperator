<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['reviewId'])) {
    $manager = new Manager($db);
    $review = $manager->readReviewById($_POST['reviewId']);
    $review->setAuthorId($_POST['authorId']);
    $review->setTourOperatorId($_POST['tourOperatorId']);
    $review->setScore($_POST['score']);
    $review->setMessage($_POST['message']);
    
    $result = $manager->updateReview($review);
    if ($result) {
        header("Location:../manage_reviews.php?reviewId={$_POST['reviewId']}&info=updateReviewSuccess");
        die();
    } else {
        header("Location:../manage_reviews.php?reviewId={$_POST['reviewId']}&info=updateReviewFailed");
        die();
    }
} else {
    header("Location:../manage_reviews.php?redirectedFrom={$currentFile}&info=reviewIdIsNotSet");
    die();
}