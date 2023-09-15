<?php

use class\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);

$destination = $manager->createDestination("tets", rand(9999,99999), 1, "/keke.pnp");
echo "<pre>";
var_dump($destination);
echo "</pre>";

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>

</body>
</html>