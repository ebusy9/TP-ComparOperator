<?php

use class\DestinationManager;
use class\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit();
} else {
    $dbManager = new Manager($db);
    $destinationManager = new DestinationManager($db);

    $operator = $dbManager->getOperatorById($_GET['id']);
    $destinations = $destinationManager->getAllDestinations();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComparOperator</title>
</head>

<body>

    <div id="destinations">
        <?php
        foreach ($destinations as $destination) {
            echo <<<HTML
    <div id="id-{$destination->getId()}">
        <h4>{$destination->getLocation()}</h4>
        <img src="{$destination->getImg()}" alt="no image">
        <p>Prix : {$destination->getPrice()} €</p>
        <button onclick="deleteDestination({$destination->getId()})">DELETE</button>
    </div>
HTML;
        }
        ?>

    </div>



<script src="assets/js/manageto.js"></script>
</body>

</html>