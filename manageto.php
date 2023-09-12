<?php

use class\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit();
} else {
    $dbManager = new Manager($db);

    $operator = $dbManager->getOperatorById($_GET['id']);
    $destinations = $dbManager->getDestinationsByOperatorId($_GET['id']);
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
            if (isset($destination['img'])) {
                $img = $destination['img'];
            } else {
                $img = "";
            }
            echo <<<HTML
    <div id="id-{$destination['id']}">
        <h4>{$destination['location']}</h4>
        <img src="{$img}" alt="no image">
        <p>Prix : {$destination['price']} €</p>
        <button onclick="deleteDestination({$destination['id']})">DELETE</button>
    </div>
HTML;
        }
        ?>

    </div>



<script src="assets/js/manageto.js"></script>
</body>

</html>