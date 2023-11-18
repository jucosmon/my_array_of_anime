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

    <title>Home Page</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand text-uppercase active" href="index.php"><i class="fa-solid fa-layer-group"
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
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php#about">About</a>
                    </li>
                </ul>

            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">


                    <form class="d-flex" role="search" action="searchAnime.php" method="GET">
                        <input class="form-control me-2" name="searchname" type="search" placeholder="Search"
                            aria-label="Search" required>
                        <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"
                                style="color: #ffffff;"></i></button>
                    </form>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-bookmark" style="color: #f2f2f2;"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="towatchlist.php">To Watch</a></li>
                            <li><a class="dropdown-item" href="ongoingList.php">In Progress</a></li>
                            <li><a class="dropdown-item" href="finishedList.php">Finished</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="favorites.php">Favorites</a></li>
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
        <div class="container-fluid d-flex justify-content-center my-lg-5" style=" height: 100%; margin-top: 10%">
            <div class="container-fluid my-5 ">
                <div class=" card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="favorites.php"><i class="fa-solid fa-star"
                                        style="color: #455f50;"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="true" href="towatchlist.php">To Watch</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ongoingList.php">In Progress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="finishedList.php">Finished</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>