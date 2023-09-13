<?php

use class\DestinationManager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new DestinationManager($db);

$destination = $manager->createDestination("tets", 23, 1, "/keke.pnp");
echo "<pre>";
var_dump($destination);
echo "</pre>";


$destinations = $manager->getAllDestinations();

echo "<pre>";
var_dump($destinations);
echo "</pre>";
