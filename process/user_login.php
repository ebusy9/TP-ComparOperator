<?php

use Class\Manager\Manager;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";


if (isset($_POST['rememberMe']) && !isset($_COOKIE['login'])) {
    setcookie('login', htmlentities($_POST['login']), time() + 86400 * 365, "/");
} elseif (isset($_POST['rememberMe']) && isset($_COOKIE['login']) && $_COOKIE['login'] !== $_POST['login']) {
    setcookie('login', htmlentities($_POST['login']), time() + 86400 * 365, "/");
} elseif (!isset($_POST['rememberMe']) && isset($_COOKIE['login'])) {
    setcookie('login', false, time() - 86400 * 365, "/");
}


$login = htmlspecialchars(strtolower($_POST['login']));


try {
    $queryUsers = $db->prepare("SELECT * FROM user WHERE login = :login");
    $queryUsers->execute([':login' => $login]);
    $fetchedUser = $queryUsers->fetch();
} catch (PDOException $exception) {
    $_SESSION['lastErrMsg'] = $exception->getMessage();
    header('Location: ../login.php?err=loginFetch');
    exit();
}

if ($fetchedUser === false) {
    header('Location: ../login.php?err=loginPassword');
    exit();
}


function login(array $fetch, string $password)
{
    if (password_verify($password, $fetch['password'])) {
        $_SESSION['userId'] = $fetch['user_id'];
        $_SESSION['username'] = $fetch['username'];
        if (isset($_POST['stayLoggedIn'])) {
            setcookie('stayLoggedIn', true, time() + 86400 * 365, "/");
            setcookie('userId', $fetch['user_id'], time() + 86400 * 365, "/");
            setcookie('username', $fetch['username'], time() + 86400 * 365, "/");
        } else {
            setcookie('stayLoggedIn', false, -1, '/');
            setcookie('userId', false, -1, '/');
            setcookie('username', false, -1, '/');
        }
        header('Location: ../index.php?info=loginSuccess');
        exit();
    } elseif (password_verify($password, $fetch['password'])) {
        header('Location: ../login.php?err=ipAdressDoesNotMatch');
        exit();
    }
    header('Location: ../login.php?err=password');
    exit();
}


login($fetchedUser, $_POST['password']);