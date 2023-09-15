<?php

use class\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);

// $destination = $manager->createDestination("tets", rand(9999,99999), 1, "/keke.pnp");
// echo "<pre>";
// var_dump($destination);
// echo "</pre>";

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";


// $destinations = $manager->updateDestination(new Destination(["id" => 41748, "location" => "Miami", "price" => 9463, "operatorId" => 2, "img" => "/miami.jpg"]));

echo "<pre>";
var_dump($manager->getAllTourOperatorByDestinationLocation('tets'));
echo "</pre>";