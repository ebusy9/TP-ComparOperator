<?php

use class\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php"; 

$dbManager = new Manager($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
                
    <title>ComparOperator</title>

 
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" id="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="assets/logo/Logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
                    Coperator
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Page Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="">
    <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card" style="margin-top: -15px; background-color: #40514E;">
                <div class="card-body">
                    <form class="row g-3">
                        <div class="col-12 col-md-4">
                            <input class="form-control form-control-lg" type="text" placeholder="De: Ville, gare, aéroport ou port" aria-label=".form-control-lg example">
                        </div>
                        <div class="col-12 col-md-4">
                            <input class="form-control" type="text" placeholder="Vers: Ville, gare, aéroport ou port" aria-label="default input example">
                        </div>
                        <div class="col-6 col-md-2">
                            <input class="form-control" type="date" placeholder="Date de Départ" aria-label=".form-control-sm example">
                        </div>
                        <div class="col-6 col-md-2">
                            <input class="form-control" type="date" placeholder="Date de Retour" aria-label=".form-control-sm example">
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="text" placeholder="Adulte" aria-label=".form-control-sm example">
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="text" placeholder="Jeune" aria-label=".form-control-sm example">
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-center">
                               <button id="btns" type="button" class="btn btn-primary btn-sm">
                                   <i class="fas fa-search"></i> Rechercher
                                      </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</section>


    <footer>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/82dc073821.js" crossorigin="anonymous"></script>
</body>
</html>
