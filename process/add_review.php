<?php

use class\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";


if (isset($_POST['authorName'])) {
    $review = (new Manager($db))->publishOrUpdateReview(htmlspecialchars($_POST['authorName']), $_POST['tourOperatorId'],  $_POST['scoreValue'],  htmlspecialchars($_POST['message']));
    if ($review) {
        header("Location:../location.php?name={$_POST['locationName']}&info=addReviewSuccess");
        die();
    } else {
        header('Location:../location.php?redirectedFrom=add_review&info=addReviewFailed');
        die();
    }
} else {
    header('Location:../location.php?redirectedFrom=add_review&info=authorNameIsNotSet');
    die();
}
