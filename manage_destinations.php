<?php

use Class\Manager\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$destinationList = $manager->readDestinationAll();


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
    <div class="modal fade" id="addDestinationForm" tabindex="-1" aria-labelledby="AddTourOperatorFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header" id="modal-header">
                    <h1 class="modal-title fs-5" id="addTourOperatorFormLabel">New Destination</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="process/add_destination.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Location</label>
                                <input type="text" class="form-control bg-dark " name="destinationName" id="nameInput" placeholder="Roanne" required>
                            </div>
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Thumbnail</label>
                                <input type="file" class="form-control bg-dark" name="destinationImg" id="fileInput" accept="image/*" required>
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
                    <a href="index.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none text-reset">
                        <span class="fs-5 d-none d-sm-inline">COperator BO</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="admin.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-house"></i> Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="manage_destinations.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-map-location"></i> Destinations</span>
                            </a>
                        <li class="nav-item">
                            <a href="manage_offers.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-coins"></i> Offers</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="manage_reviews.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-star-half-stroke"></i> Reviews</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="manage_authors.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-pen-nib"></i> Authors</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container-fluid" style="max-width: 85%;">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-success mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#addDestinationForm"><i class="fa-solid fa-plus"></i> Add Destination</button>
                <!-- Button trigger modal -->
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($destinationList !== null) {
                            foreach ($destinationList as $destination) {
                                echo <<<HTML
                                    <!-- Modal -->
                                    <div class="modal fade" id="updateDestinationForm{$destination->getDestinationId()}" tabindex="-1" aria-labelledby="AddTourOperatorFormLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark">
                                                <div class="modal-header" id="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateDestinationForm{$destination->getDestinationId()}Label">Edit Destination</h1>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <form action="process/update_destination.php" method="post" enctype="multipart/form-data">
                                                            <div class="mb-3">
                                                                <label for="nameInput" class="form-label">Location</label>
                                                                <input type="text" class="form-control bg-dark " name="destinationName" id="nameInput" placeholder="Roanne" value="{$destination->getDestinationName()}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="fileInput" class="form-label">Thumbnail</label>
                                                                <input type="file" class="form-control bg-dark" name="destinationImg" id="fileInput" accept="image/*">
                                                            </div>
                                                            <input type="hidden" name="destinationId" value="{$destination->getDestinationId()}">
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
                                  </tr>
                                  <td>{$destination->getDestinationId()}</td>
                                  <td>{$destination->getDestinationName()}</td>
                                  <td><a href="{$destination->getDestinationImg()}" class="text-decoration-none">link</a></td>
                                  <td><a href="#updateDestinationForm{$destination->getDestinationId()}" data-bs-toggle="modal" data-bs-target="#updateDestinationForm{$destination->getDestinationId()}" style="margin-right: 0.75rem;"><i class="fa-solid fa-pen" style="color: #ffffff;"></i></a> <a href="/process/delete_destination.php?id={$destination->getDestinationId()}"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a></td>
                                </tr>
                                HTML;
                            }
                        } else {
                            echo <<<HTML
                            <p>Destination not found</p>
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