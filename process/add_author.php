<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_POST['authorName'])) {
    $author = $manager->createAuthor($_POST['authorName']);
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