<?php
session_start();
include("db_connection.php"); // Include the file containing the database connection
include("functions.php");

$user_data = check_login($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="custom.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.2/css/bootstrap.min.css" />
    <script src="bootstrap/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Edit Profile</title>
</head>

<body id="profile-body">
    <nav class="navbar navbar-expand-lg fixed-top navbar-shadow">
        <div class="container">
            <a class="navbar-brand text-uppercase" href="index.php"><i class="fa-solid fa-layer-group"
                    style="color: #ffffff;"></i> My
                Array of Anime</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#trending">Trending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="index.php#recommendations">Recommendations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="index.php#facts">Facts</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php#">About</a>
                    </li>
                </ul>

            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">


                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-bookmark" style="color: #f2f2f2;"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">To Watch</a></li>
                            <li><a class="dropdown-item" href="#">In Progress</a></li>
                            <li><a class="dropdown-item" href="#">Finished</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Favorites</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <main>
        <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
            <div class="card p-3">
                <h2 class="mb-4">Edit Profile</h2>
                <form method="POST" action="update.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="<?php echo $user_data['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                    </div>
                    <div class="button-container">
                        <a href="profile.php" class="btn btn-secondary" id="c-button">Cancel</a>
                        <button type="submit" class="btn btn-danger" id="c-button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>