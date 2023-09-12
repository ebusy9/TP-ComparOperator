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
               <div class="card" style="width: 18rem; margin: -15px; margin-left: 40px;">
  <ul class="list-group list-group-flush">
  <input class="form-control form-control-lg" type="text" placeholder="Départ" aria-label=".form-control-lg example">
  <input class="form-control" type="text" placeholder="Destination" aria-label="default input example">
  </ul>
  <div class="container text-center">
  <div class="row">
    <div class="col-6 col-sm-3">
        <input class="form-control form-control-sm" type="number" placeholder="Date de Départ" aria-label=".form-control-sm example">
</div>
    <div class="col-6 col-sm-3">
    <input class="form-control form-control-sm" type="number" placeholder="Date de Retour" aria-label=".form-control-sm example">
    </div>

    <!-- Force next columns to break to new line -->
    <div class="w-100"></div>

    <div class="col-6 col-sm-3">
    <input class="form-control form-control-sm" type="select" placeholder="Adulte" aria-label=".form-control-sm example">
    </div>
    <div class="col-6 col-sm-3">
    <input class="form-control form-control-sm" type="select" placeholder="Jeune" aria-label=".form-control-sm example">  
    </div>
  </div>
</div>

</ul>
  <div class="card-footer" style="align-items: center;">
   <button id="btns" type="button" class="btn btn-primary"
        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 5.5rem; --bs-btn-font-size: .75rem;">
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>  Rechercher
</button>
  </div>
</div>

               </section>


                    <footer>


                    </footer>

<body>
    

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/82dc073821.js" crossorigin="anonymous"></script>
</html>