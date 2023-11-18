<?php

if (isset($_GET['searchname'])) {
    $animeTitle = $_GET['searchname'];
    $animeListUrl = 'https://api.jikan.moe/v4/anime';
    $animeListResponse = file_get_contents($animeListUrl);
    $animeList = json_decode($animeListResponse, true);

    $filteredAnime = array_filter($animeList['data'], function ($anime) use ($animeTitle) {
        return isset($anime['title']) && stripos($anime['title'], $animeTitle) !== false;
    });

    $resultArray = []; // Initialize an array to store filtered anime

    if (empty($filteredAnime)) {
        echo '<p>No results found.</p>';
    } else {
        foreach ($filteredAnime as $anime) {
            $resultArray[] = [
                'title' => $anime['title'],
                'episodes' => $anime['episodes'],
                'rating' => $anime['rating'],
                'synopsis' => $anime['synopsis'],
                'image_url' => $anime['images']['jpg']['large_image_url'],
                'genres' => (isset($anime['genres']) && is_array($anime['genres'])) ?
                    implode(', ', array_column($anime['genres'], 'name')) :
                    ''
            ];
        }
    }

}

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

    <title>Search</title>
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

        <!-- mao nig modal  -->
        <section class="modal fade" tabindex="-1" id="watchlist-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Watchlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post">
                            <div class="form-floating">
                                <select name="watchlist-option" id="watchlist-option" class="form-select">
                                    <option value="To Watch">To Watch</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Done Watching">Finished</option>
                                </select>
                                <label for="watchlist-option">Choose an option: </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="c-button">Save changes</button>
                    </div>
                </div>
            </div>
        </section>


        <!-- trending section -->
        <section id="trending" class="pt-md-5">
            <h2 class="text-center my-5">Search Results</h2>
            <?php if (empty($filteredAnime)) { ?>
                <p class="text-center my-5">No results found</p>
            <?php } ?>
            <div class="container">
                <div class="row">
                    <?php foreach ($resultArray as $anime): ?>
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 c-card">
                                <div style="height: 200px; overflow: hidden;">
                                    <img src="<?php echo $anime['image_url']; ?>" class="card-img-top img-fluid"
                                        style="height: 100%; object-fit: cover;" alt="Anime Image">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $anime['title']; ?>
                                    </h5>
                                    <p class="card-text">Genre:
                                        <?php echo $anime['genres']; ?>
                                    </p>
                                    <p class="card-text" style="height: 80px; overflow: hidden;">
                                        <?php echo substr($anime['synopsis'], 0, 200); ?>
                                        <?php echo strlen($anime['synopsis']) > 200 ? '...' : ''; ?>
                                    </p>
                                    <p class="card-text">Episodes:
                                        <?php echo $anime['episodes']; ?>
                                    </p>
                                    <p class="card-text">Rating:
                                        <?php echo $anime['rating']; ?>
                                    </p>
                                    <button class="btn btn-primary" id="c-button" data-bs-toggle="modal"
                                        data-bs-target="#watchlist-modal">Add to Watchlist</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


        </section>

    </main>



</body>

</html>