<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['authorId'])) {
    $manager = new Manager($db);
    $author = $manager->readAuthorById($_POST['authorId']);
    $author->setAuthorName($_POST['authorName']);

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