<?php

use Class\Manager\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);

// $destination = $manager->createDestination("tets", rand(9999,99999), 1, "/keke.pnp");
// echo "<pre>";
// var_dump($destination);
// echo "</pre>";

// $destinations = $manager->publishOrUpdateReview("test", 1, 3, "test1");


echo "<pre>";
// var_dump($certificate = $manager->createCertificate(55079, date('Y-m-d H:i:s'), "Jenya"));



var_dump($to = $manager->readTourOperatorAll());
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

