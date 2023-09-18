<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_POST['authorId'])) {
    $author = $manager->readAuthorById($_POST['authorId']);

    $result = $manager->updateAuthor($author);

    if ($result) {
        header("Location:../manage_authors.php?authorId={$_POST['authorId']}&info=updateAuthorSuccess");
        die();
    } else {
        header("Location:../manage_authors.php?authorId={$_POST['authorId']}&info=updateAuthorFailed");
        die();
    }
} else {
    header("Location:../manage_authors.php?redirectedFrom={$currentFile}&info=authorIdIsNotSet");
    die();
}