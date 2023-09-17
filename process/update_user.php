<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_POST['userId'])) {
    $manager = new Manager($db);
    $manager->verifyLoginStatus();
    $user = $manager->readUserById($_POST['userId']);
    $user->setIsAdmin($_POST['isAdmin']);
    $user->setUsername($_POST['username']);
    
    $result = $manager->updateUser($user);
    if ($result) {
        header("Location:../manage_users.php?userId={$_POST['userId']}&info=updateuserSuccess");
        die();
    } else {
        header("Location:../manage_users.php?userId={$_POST['userId']}&info=updateuserFailed");
        die();
    }
} else {
    header("Location:../manage_users.php?redirectedFrom={$currentFile}&info=userIdIsNotSet");
    die();
}