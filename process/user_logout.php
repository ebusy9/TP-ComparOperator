<?php

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

setcookie('stayLoggedIn', false, -1, '/');
setcookie('userId', false, -1, '/');
setcookie('username', false, -1, '/');
session_destroy();

header ("Location: ../login.php");
exit();