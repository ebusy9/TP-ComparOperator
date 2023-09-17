<?php

use Class\Manager\Manager;

include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "autoload.php";
include_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "db.php";

$manager = new Manager($db);
$manager->verifyLoginStatus();
$userList = $manager->readUserAll();


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
    <title>COperator BO</title>
</head>



<body>
    <!-- Modal -->
    <div class="modal fade" id="addUserForm" tabindex="-1" aria-labelledby="addUserFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header" id="modal-header">
                    <h1 class="modal-title fs-5" id="addUserFormLabel">New User</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="process/add_user.php" method="post">
                            <div class="mb-3">
                                <label for="userNameInput" class="form-label">Username</label>
                                <input type="text" class="form-control bg-dark " name="username" id="userNameInput" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginInput" class="form-label">Login</label>
                                <input type="text" class="form-control bg-dark " name="login" id="loginInput" placeholder="Login" required>
                            </div>
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Password</label>
                                <input type="password" class="form-control bg-dark " name="password" id="passwordInput" placeholder="Passwor" required>
                            </div>
                            <div class="mb-3">
                                <label for="statusSelect" class="form-label">Status</label>
                                <select type="text" class="form-control bg-dark " name="isAdmin" id="statusSelect" required>
                                    <option selected style="color: grey;">Select status...</option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                    </div>
                    <input type="hidden" name="userId" value="{$user->getUserId()}">
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
                        <li class="nav-item">
                            <a href="manage_users.php" class="nav-link align-middle px-0 text-decoration-none text-reset">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline "><i class="fa-solid fa-user"></i> Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container-fluid" style="max-width: 85%;">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-success mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#addUserForm"><i class="fa-solid fa-plus"></i> Add User</button>
                <!-- Button trigger modal -->
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Login</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Status</th>

                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($userList !== null) {
                            foreach ($userList as $user) {
                                $date = date('d/m/Y H:i:s', strtotime($user->getRegistrationDate()));
                                if ($user->getIsAdmin() === false) {
                                    $status = "User";
                                } else {
                                    $status = "Admin";
                                }

                                echo <<<HTML
                                    <!-- Modal -->
                                    <div class="modal fade" id="updateUserForm{$user->getUserId()}" tabindex="-1" aria-labelledby="updateUserForm{$user->getUserId()}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark">
                                                <div class="modal-header" id="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateUserForm{$user->getUserId()}Label">Edit User</h1>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <form action="process/update_user.php" method="post">
                                                            <div class="mb-3">
                                                                <label for="userNameInput" class="form-label">Username</label>
                                                                <input type="text" class="form-control bg-dark " name="username" id="userNameInput" placeholder="Username" value="{$user->getUsername()}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="statusSelect" class="form-label">Status</label>
                                                                <select type="text" class="form-control bg-dark " name="isAdmin" id="statusSelect">

                                    HTML;
                                if ($status === "User") {
                                    echo <<<HTML
                                                                <option selected value="0">User</option>
                                                                <option value="1">Admin</option>
                                    HTML;
                                } else {
                                    echo <<<HTML
                                                                <option value="0">User</option>
                                                                <option selected value="1">Admin</option>
                                    HTML;
                                }
                                echo <<<HTML
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <input type="hidden" name="userId" value="{$user->getUserId()}">
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
                                  <td>{$user->getUserId()}</td>
                                  <td>{$user->getUsername()}</td>
                                  <td>{$user->getLogin()}</td>
                                  <td>{$date}</td>
                                  <td>{$status}</td>
                                  <td><a href="#updateUserForm{$user->getUserId()}" data-bs-toggle="modal" data-bs-target="#updateUserForm{$user->getUserId()}" style="margin-right: 0.75rem;"><i class="fa-solid fa-pen" style="color: #ffffff;"></i></a> <a href="/process/delete_user.php?id={$user->getUserId()}"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a></td>
                                </tr>
                                HTML;
                            }
                        } else {
                            echo <<<HTML
                            <p>Author not found</p>
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