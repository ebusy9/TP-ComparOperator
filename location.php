<?php

use Class\Manager\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$destinations = $manager->readDestinationAll();
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

<body style=" font-family: 'SF Pro Display', sans-serif;">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" id="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="assets/logo/Logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-center">
                    Comperator
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Page Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Page d'accueil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>





    <p class="font-weight-bold">
    <h3>Nos meilleures offres sélectionées pour vous</h3>
    </p>

    <div class="container" style="margin-top: auto;">
        <?php foreach ($destinations  as $destination) {
            $offerDestinationWithLowestPrice = $manager->readOfferDestinationByDestinationIdWithLowestPrice($destination->getDestinationId());

            echo <<<HTML

                        <div class="row justify-content-center">
                        <div class="col-md-8">
                        <div class="card">
                        <div class="row g-0">
                        <div class="col-md-4">
                        <img src="{$destination->getDestinationImg()}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                        <h5 class="card-title">{$destination->getDestinationName()}</h5>

                HTML;

            if ($offerDestinationWithLowestPrice !== null) {
                echo <<<HTML
                    <p class="card-text"><small class="text-body-secondary">À partir de {$offerDestinationWithLowestPrice->getPrice()} €</small></p>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                    <button onclick="window.location.href='tour.php?destinationId={$destination->getDestinationId()}';" id="btns" type="button" class="btn btn-sm text-light">
                        Plus de Détail
                    </button>
                    </div>
             HTML;
            } else {
                echo <<<HTML
                <p class="card-text"><small class="text-body-secondary">Aucune offre pour le moment</small></p>
                <div class="col-12 d-flex align-items-center justify-content-center">
                <button onclick="window.location.href='tour.php?destinationId={$destination->getDestinationId()}';" id="btns" type="button" class="btn btn-sm text-light" disabled>
                    Plus de Détail
                </button>
                </div>                
              HTML;
            }
            echo <<<HTML
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  HTML;
        }
        ?>
    </div>



    <div class="footer-basic">
        <footer>
            <div class="social"><a href="#"><i class="fa-brands fa-instagram"></i></a><a href="#"><i class="fa-brands fa-snapchat"></i></a><a href="#"><i class="fa-brands fa-x-twitter"></i></a><a href="#"><i class="fa-brands fa-facebook-f"></i></a></div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Services</a></li>
                <li class="list-inline-item"><a href="#">About</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
            </ul>
            <p class="copyright">Kogey & Evgenii © 2023</p>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/82dc073821.js" crossorigin="anonymous"></script>
</body>

</html>