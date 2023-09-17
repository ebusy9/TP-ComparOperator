<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

if (isset($_SESSION['userId'])) {
    header('Location: index.php?info=userLoggedIn');
    exit();
} else if (isset($_COOKIE['stayLoggedIn'])) {
    $_SESSION['idUser'] = (int)$_COOKIE['id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['pfpLink'] = $_COOKIE['pfpLink'];
    header('Location: index.php?info=userAutoLoggedIn');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/login.css">
    <title>COperator Login</title>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center mt-5">


        <div class="card">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item text-center">
                    <a class="nav-link active btl" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Se connecter</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link btr" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">S'inscrire</a>
                </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <h3 class="text-center mb-3 mt-4">COperator</h3>
                    <div class="form px-4 pt-0 mt-5">
                        <form action="process/user_login.php" method="post">

                            <input type="text" name="login" class="form-control" placeholder="Nom d'utilisateur" required <?php if (isset($_COOKIE['login'])) {
                                                                                                                                echo "value=\"{$_COOKIE['login']}\"";
                                                                                                                            } ?>>

                            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                            <div class="form-check  form-switch mr-1">
                                <input class="form-check-input" type="checkbox" name="rememberMe" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Se souvenir de moi
                                </label>
                            </div>
                            <div class="form-check  form-switch mr-0">
                                <input class="form-check-input" type="checkbox" name="stayLoggedIn">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Rester connecté
                                </label>
                            </div>
                            <button class="btn btn-dark btn-block" type="submit">Connexion</button>
                        </form>
                    </div>



                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                    <div class="form px-4">
                        <form action="process/user_signup.php" method="post">

                            <input type="text" name="createUsername" class="form-control" placeholder="Nom Prénom">

                            <input type="text" name="createLogin" class="form-control" placeholder="Nom d'utilisateur">

                            <input type="password" name="createPassword" class="form-control" placeholder="Mot de passe">

                            <input type="password" name="confirmPassword" class="form-control" placeholder="Confirmation mot de passe">

                            <button class="btn btn-dark btn-block" type="submit">Inscription</button>

                        </form>

                    </div>



                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>