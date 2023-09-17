<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();

if (isset($_GET['id'])) {
    $result = $manager->deleteUserById($_GET['id']);
    if ($result) {
        header("Location:../manage_users.php?userId={$_GET['id']}&info=delteUserSuccess");
        die();
    } else {
        header("Location:../manage_users.php?userId={$_GET['id']}&info=delteUserFailed");
        die();
    }
} else {
    header("Location:../manage_users.php?redirectedFrom={$currentFile}&info=idIsNotSet");
    die();
}