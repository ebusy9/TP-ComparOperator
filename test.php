<?php

use class\Destination;
use class\DestinationManager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new DestinationManager($db);

$destination = $manager->createDestination("tets", 23, 1, "/keke.pnp");
echo "<pre>";
var_dump($destination);
echo "</pre>";


$destinations = $manager->updateDestination(new Destination(["id" => 41748, "location" => "Miami", "price" => 9463, "operatorId" => 2, "img" => "/miami.jpg"]));

echo "<pre>";
var_dump($destinations);
echo "</pre>";
