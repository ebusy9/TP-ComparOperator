<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();

if (isset($_GET['id'])) {
    $result = $manager->deleteAuthorById($_GET['id']);
    if ($result) {
        header("Location:../manage_authors.php?redirectedFrom={$currentFile}&info=deleteAuthorSuccess");
        die();
    } else {
        header("Location:../manage_authors.php?redirectedFrom={$currentFile}&info=deleteAuthorFailed");
        die();
    }
} else {
    header("Location:../manage_authors.php?redirectedFrom={$currentFile}&info=idIsNotSet");
    die();
}