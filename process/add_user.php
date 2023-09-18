<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$currentFile = basename($_SERVER['PHP_SELF']);

if (isset($_POST['login'])) {
    $user = $manager->createUser($_POST['login'], $_POST['password'], $_POST['username'], $_POST['isAdmin']);
    if ($user) {
        header("Location:../manage_users.php?login={$_POST['login']}&info=addUserSuccess");
        die();
    } else {
        header("Location:../manage_users.php?login={$_POST['login']}&info=addUserFailed");
        die();
    }
} else {
    header("Location:../manage_users.php?redirectedFrom={$currentFile}&info=loginIsNotSet");
    die();
}