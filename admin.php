<?php

use class\Manager;


include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$dbManager = new Manager($db);
$tourOperatorList = $dbManager->getAllTourOperator();


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>ComparOperator</title>

</head>



<body>




    <div class="container-fluid">

        <div class="row flex-nowrap">

            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">

                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Accueil Site</span>
                            </a>
                        </li>
                        <li>
                            <a href="tour.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Selection Tour</span> </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            </ul>
                </div>

            </div>

            <!-- <form id="create" method="post" action="">
                <input class="form" type="text" name="name" id="name" required>
                <div class="btn-group">

                </div>
                <button class="btn btn-warning" type="submit">Nouvelle destination</button>
            </form> -->
            <div class="container-fluid">
                <?php
                foreach ($tourOperatorList as $tourOperator) {


                    echo <<<HTML
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{$tourOperator->getImg()}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{$tourOperator->getName()}</h5>
HTML;

                    $certificate = $tourOperator->getCertificate();
                    if ($certificate !== null) {
                        $expirationTimestamp = strtotime($certificate->getExpiresAt());
                        $currentTimestamp = time();
                    }
                    if ($certificate === null) {
                        echo "<p class='card-text'>PREMIUM: non</p>";
                    } elseif ($certificate !== null && $expirationTimestamp < $currentTimestamp) {
                        echo "<p class='card-text'>PREMIUM: non (expiré)</p>";
                    } elseif ($certificate !== null && $expirationTimestamp > $currentTimestamp) {
                        echo "<p class='card-text'>PREMIUM: oui</p>";
                        echo "<p class='card-text'>Expires: {$certificate->getExpiresAt()}</p>";
                        echo "<p class='card-text'>Signatory: {$certificate->getSignatory()}</p>";
                    }

                    echo <<<HTML
                            <a href="process/delete_to.php?id={$tourOperator->getId()}" class="btn btn-danger">Supprimer</a>
                            <a href="manageto.php?id={$tourOperator->getId()}" class="btn btn-warning">Modifier</a>
                        </div>
                    </div>
HTML;
                }
                ?>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="assets/js/admin.js"></script>
</body>


</html>