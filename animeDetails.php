<?php
session_start();
include("db_connection.php"); // Include the file containing the database connection
include("functions.php"); //stores username data

$user_data = check_login($conn);

// Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    // Get the anime ID from the URL query parameter
    $animeID = $_GET['id'];
    $animeDetailsUrl = "https://api.jikan.moe/v4/anime/$animeID";

    // Fetch data from the API endpoint
    $animeDetailsResponse = file_get_contents($animeDetailsUrl);

    if ($animeDetailsResponse !== false) {
        // Decode JSON response
        $animeDetails = json_decode($animeDetailsResponse, true);

        if ($animeDetails && isset($animeDetails['data'])) {
            // Extract and store attributes from the data
            $id = $animeDetails['data']['mal_id'];
            $title = $animeDetails['data']['title'];
            $synopsis = $animeDetails['data']['synopsis'];
            $imageUrl = $animeDetails['data']['images']['jpg']['image_url'];
            $type = $animeDetails['data']['type'];
            $episodes = $animeDetails['data']['episodes'];
            $status = $animeDetails['data']['status'];
            // Extract genres
            $genres = [];
            foreach ($animeDetails['data']['genres'] as $genre) {
                $genres[] = $genre['name'];
            }
            $genresList = implode(", ", $genres);

        } else {
            echo "Anime details not found.";
        }
    } else {
        echo "Failed to fetch anime details from the API.";
    }


} else {
    echo '<p>No anime ID specified.</p>';
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

    <title>Details</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
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
        <section class="modal fade" tabindex="-1" id="watchlist-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Watchlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="insertAnimeDb.php" method="POST">

                        <div class="modal-body">
                            <input type="hidden" name="animeID" id="animeIDInput" value="">
                            <div class="form-floating">
                                <select name="watchlistOption" id="watchlistOption" class="form-select">
                                    <option value="to_watch">To Watch</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="finished">Finished</option>
                                </select>
                                <label for="watchlistOption">Choose an option: </label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="c-button">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <div class="container h-100 my-5">
            <div class="row no-gutters">
                <div class="col-lg-4">
                    <img src="<?php echo $imageUrl; ?>" class="card-img img-fluid anime-img" alt="Anime Image">
                </div>
                <div class="col-lg-8">
                    <div class="card-body my-3">
                        <h2 class="card-title">
                            <?php echo $title; ?>
                        </h2>
                        <p class="card-text-lg text-md">Genre:
                            <?php echo $genresList; ?>
                        </p>
                        <p class="card-text-lg text-md">
                            <?php echo $synopsis; ?>
                        </p>
                        <p class="card-text-lg text-md">Type:
                            <?php echo $type; ?>
                        </p>
                        <p class="card-text-lg text-md">Status:
                            <?php echo $status; ?>
                        </p>
                        <p class="card-text-lg text-md">Episodes:
                            <?php echo $episodes; ?>
                        </p>
                        <div class="mt-auto d-flex justify-content-end">
                            <a href="insertFavorites.php?id=<?php echo $id; ?>" class="btn btn-primary me-2"
                                id="c-button"><i class="fa-solid fa-heart" style="color: #ffffff;"></i></a>
                            <button class="btn btn-primary" id="c-button" data-bs-toggle="modal"
                                data-bs-target="#watchlist-modal" data-animeID="<?php echo $id; ?>">
                                <i class=" fa-solid fa-bookmark" style="color: #f2f2f2;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- TRANSFERRING ID FROM THE PAGE TO THE MODAL KAY AG MODAL KAY NAAY SELECT OPTIONS RA PERO NEED SAD NATO AG ANIME ID NGA  IINPUT SA DATABASE -->
    <script>
        var myModal = document.getElementById('watchlist-modal');
        myModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var animeID = button.getAttribute('data-animeID');
            var modalInput = myModal.querySelector('#animeIDInput');
            modalInput.value = animeID;
        });
        // Check if a PHP session variable containing an error message is set   
        <?php if (isset($_SESSION['message'])): ?>
            // Display an alert using JavaScript with the message from the PHP session
            alert("<?php echo $_SESSION['message']; ?>");
        <?php endif; ?>
        // Clear the message from the session
        <?php unset($_SESSION['message']); ?>

    </script>

</body>



</html>