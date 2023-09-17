<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['authorName'])) {
    $author = (new Manager($db))->createAuthor($_POST['authorName']);
    if ($author) {
        header("Location:../manage_authors.php?authorName={$_POST['authorName']}&info=addAuthorSuccess");
        die();
    } else {
        header("Location:../manage_authors.php?authorName={$_POST['authorName']}&info=addAuthorFailed");
        die();
    }
} else {
    header("Location:../manage_authors.php?redirectedFrom={$currentFile}&info=authorNameIsNotSet");
    die();
}