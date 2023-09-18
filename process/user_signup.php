<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

unset($_SESSION['signupErr']);

$manager = new Manager($db);


$login = strtolower($_POST['createLogin']);
$password = $_POST['createPassword'];
$username = $_POST['createUsername'];
$confirmPassword = $_POST['confirmPassword'];

$loginErr = $manager->validateLogin($login);
$passwordErr = $manager->validatePassword($password, $confirmPassword);
$usernameErr = $manager->validateUsername($username, $login);

if ($loginErr || $passwordErr || $usernameErr) {
    $_SESSION['signupErr']['createLogin'] = $loginErr;
    $_SESSION['signupErr']['createPassword'] = $passwordErr;
    $_SESSION['signupErr']['createUsername'] = $usernameErr;
    header('Location: ../login.php?err=signupRequirements');
    exit();
} elseif (isset($login) && isset($password) && isset($username)) {
    $user = $manager->userSignup($username, $login, $password);

    $_SESSION['userId'] = $user->getUserId();
    $_SESSION['username'] = $user->getUsername();
    header("Location: ../index.php");
    exit();
} else {
    echo "Something went wrong!";
    echo $_SESSION['signupErr'];
    exit();
}


