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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/admin.css">
    <title>ComparOperator</title>
</head>



<body>
    <!-- Modal -->
    <div class="modal fade" id="addTourOperatorForm" tabindex="-1" aria-labelledby="AddTourOperatorFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header" id="modal-header">
                    <h1 class="modal-title fs-5" id="addTourOperatorFormLabel">New Tour Operator</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="process/add_to.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Company name</label>
                                <input type="text" class="form-control bg-dark " name="name" id="nameInput" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="linkInput" class="form-label">Website</label>
                                <input type="url" class="form-control bg-dark" name="link" id="linkInput" placeholder="https://" required>
                            </div>
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Logotype</label>
                                <input type="file" class="form-control bg-dark" name="img" id="fileInput" accept="image/*" required>
                            </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" id="sidebar" style="max-width: 15%;">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none text-reset">
                        <span class="fs-5 d-none d-sm-inline">COperator-BO</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-house"></i> Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="tour.php" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-decoration-none text-reset">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-map-location"></i> Destinations</span> </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            </ul>
                </div>
            </div>
            <div class="container-fluid" style="max-width: 85%;">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-success mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#addTourOperatorForm"><i class="fa-solid fa-plus"></i> Add Tour Operator</button>
                <!-- Button trigger modal -->
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
                                echo "<td>N/A</td>";
                                echo "<td>N/A</td>";
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
                        <td><a href="{$tourOperator->getLink()}" class="text-decoration-none">link</a></td>
                        <td><a href="{$tourOperator->getImg()}" class="text-decoration-none">link</a></td>
                        <td><a href="/manageto.php?id={$tourOperator->getId()}" style="margin-right: 0.75rem;"><i class="fa-solid fa-pen" style="color: #ffffff;"></i></a> <a href="/process/delete_to.php?id={$tourOperator->getId()}"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a></td>
                    </tr>
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