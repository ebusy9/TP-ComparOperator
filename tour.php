<?php

use Class\Manager\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";



if (!isset($_GET['destinationId'])) {
    header('Location: location.php?redirectedFrom=tour&info=destinationIdIsNotSet');
    exit();
} else {
    $manager = new Manager($db);
}
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

    <p class="font-weight-bold ">
    <h3>Résultats de Recherche</h3>
    </p>
    <div class="container" style="margin-top: auto;">

        <?php
        $offerDestinationList = $manager->readOfferDestinationByDestinationId($_GET['destinationId']);

        foreach ($offerDestinationList as $offerDestination) {

            $destination = $manager->readDestinationById($offerDestination->getDestinationId());
            $tourOperator = $manager->readTourOperatorById($offerDestination->getTourOperatorId());
            $reviewList = $tourOperator->getReview();

            echo <<<HTML
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{$tourOperator->getTourOperatorImg()}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{$tourOperator->getName()}</h5>
            HTML;

            if ($reviewList !== null) {
                $i = 0;
                $somme = 0;
                foreach ($reviewList as $review) {
                    $i++;
                    $somme += $review->getScore();
                }

                if ($somme > 0 && $i > 0) {
                    $score = floor($somme / $i);

                    echo <<<HTML
                <div class="stars score-{$score}">
                    <div class="star"></div>
                    <div class="star"></div>
                    <div class="star"></div>
                    <div class="star"></div>
                    <div class="star"></div>
                </div>
                HTML;
                }
            } else {
                echo <<<HTML
                <div>
                    <p>Aucun avis</p>
                </div>
                HTML;
            }

            echo <<<HTML
                        <button id="btns" type="button" class="btn btn-sm text-light" data-bs-toggle="modal" data-bs-target="#exampleModal{$offerDestination->getOfferDestinationId()}">
                        Avis
                        </button>
                        </div>
                        <p class="card-text"><small class="text-body-secondary">{$offerDestination->getPrice()} €</small></p>
                        <p class="card-text mb-0">Destination: {$destination->getDestinationName()}</p>

                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <button onclick="window.location.href='{$tourOperator->getLink()}';" id="btns" type="button" class="btn btn-sm text-light mb-3">
                                Voir Tour 
                            </button>
                        </div>
                        </div>
                        </div>  
                        </div>
                        </div>
                        </div>

                    <div class="modal fade " id="exampleModal{$offerDestination->getOfferDestinationId()}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Avis</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="process/publish_review.php" method="post">
                    <div class="mb-3">
                    <label for="authorName" class="form-label">Nom Prénom</label>
                    <input type="text" class="form-control" name="authorName" id="authorName" placeholder="Jean Michel">
                    </div>
                    <div class="mb-3">
                    <label for="message" class="form-label">Commentaire</label>
                    <input type="text" class="form-control" name="message" id="message" placeholder="Message">
                    </div>
                    <div class="mb-3">
                    <label for="message" class="form-label">Note</label>
                    <input type="number" class="form-control" name="score" id="message" min="1" max="5">
                    </div>

            HTML;
            foreach ($reviewList as $review) {
                $author = $manager->readAuthorById($review->getAuthorId());
                $scoreOp = $review->getScore();
                $authorName = $author->getAuthorName();
                $message = $review->getMessage();




                echo <<<HTML
                <p class="text">
                    <small class="text-body-secondary">
                        <h3>{$authorName} :</h3> {$message}
                    </small>
                </p>
                <div class="stars score-{$scoreOp}">
                    <div class="star"></div>
                    <div class="star"></div>
                    <div class="star"></div>
                    <div class="star"></div>
                    <div class="star"></div>
                </div>
HTML;
            }
            echo <<<HTML
                                </div>
                    <div class="modal-footer">
                    <input type="hidden" name="tourOperatorId" value="{$tourOperator->getTourOperatorId()}">
                    <input type="hidden" name="destinationId" value="{$destination->getDestinationId()}" >
                        <button id="btns" type="submit" class="btn btn-sm text-light">Publier</button>
                    </form>
                    </div>
                    </div>
                </div>
                </div>
            HTML;
        }
        ?>
    </div>
    
    <footer>
        <div class="footer-basic">
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
    <!-- End of .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/82dc073821.js" crossorigin="anonymous"></script>
</body>

</html>