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
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Certificate</th>
                            <th scope="col">Certificate Expiration</th>
                            <th scope="col">Certificate Issuer</th>
                            <th scope="col">URL</th>
                            <th scope="col">Image</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $penIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>';
                        $trashIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><style>svg{fill:#ffffff}</style><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>';
                        foreach ($tourOperatorList as $tourOperator) {

                            echo <<<HTML
                        </tr>
                        <td>{$tourOperator->getId()}</td>
                        <td>{$tourOperator->getName()}</td>
                        HTML;

                            $certificate = $tourOperator->getCertificate();
                            if ($certificate !== null) {
                                $expirationTimestamp = strtotime($certificate->getExpiresAt());
                                $currentTimestamp = time();
                            }
                            if ($certificate === null) {
                                echo "<td>Basic</td>";
                                echo "<td>-</td>";
                                echo "<td>-</td>";
                            } elseif ($certificate !== null && $expirationTimestamp < $currentTimestamp) {
                                echo "<td>Basic</td>";
                                echo "<td>{$certificate->getExpiresAt()}</td>";
                                echo "<td>{$certificate->getSignatory()}</td>";
                            } elseif ($certificate !== null && $expirationTimestamp > $currentTimestamp) {
                                echo "<td>Premium</td>";
                                echo "<td>{$certificate->getExpiresAt()}</td>";
                                echo "<td>{$certificate->getSignatory()}</td>";
                            }

                            echo <<<HTML
                        <td><a href="{$tourOperator->getLink()}">link</a></td>
                        <td><a href="{$tourOperator->getImg()}">link</a></td>
                        <td><a href="/manageto.php?id={$tourOperator->getId()}">{$penIcon}</a> <a href="/process/delete_to.php?id={$tourOperator->getId()}">{$trashIcon}</a></td>
                    </tr>
HTML;
                        }
                        ?>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/82dc073821.js" crossorigin="anonymous"></script>
    <script src="assets/js/admin.js"></script>
</body>


</html>