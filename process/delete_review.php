<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();

if (isset($_GET['id'])) {
    $result = $manager->deleteReviewById($_GET['id']);
    if ($result) {
        header("Location:../manage_reviews.php?authorId={$_POST['authorId']}&info=deleteReviewSuccess");
        die();
    } else {
        header("Location:../manage_reviews.php?authorId={$_POST['authorId']}&info=deleteReviewFailed");
        die();
    }
} else {
    header("Location:../manage_reviews.php?redirectedFrom={$currentFile}&info=authorIdIdIsNotSet");
    die();
}