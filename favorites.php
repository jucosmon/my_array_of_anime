<?php
session_start();
include("db_connection.php"); // Include the file containing the database connection
include("functions.php");

$user_data = check_login($conn);
$username = $user_data['username'];
// Fetch data from the database
$query = "SELECT * FROM favorites WHERE username = '$username'"; // Replace 'watchlist' with your table name
$result = mysqli_query($conn, $query);

// Check for errors in the query execution
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
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

    <title>Favorites</title>
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
                                <a class="nav-link active" aria-current="true" href="favorites.php"><i
                                        class="fa-solid fa-star" style="color: #455f50;"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="towatchlist.php">To Watch</a>
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
                        <div class="container table-container">
                            <div class="table-responsive">
                                <h2 class="my-3">Favorites</h2>
                                <?php
                                // Check if the result set is empty
                                if (mysqli_num_rows($result) == 0) {
                                    echo "<p>No list yet.</p>";
                                } else {
                                    ?>
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>View</th>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Episodes</th>
                                                <th>Delete</th>
                                                <!-- Add more table headers for other columns -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Display data from the database in the table
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                //view button
                                                echo "<td><a href='animeDetails.php?id=" . $row['anime_id'] . "' class='btn btn-primary me-2' id='c-button'><i class='fa-solid fa-eye' style='color: #ffffff;'></i></a></td>";
                                                echo "<td>" . $row['anime_id'] . "</td>";
                                                echo "<td>" . $row['title'] . "</td>";
                                                echo "<td>" . $row['type'] . "</td>";
                                                echo "<td>" . $row['status'] . "</td>";
                                                echo "<td>" . $row['episodes'] . "</td>";
                                                //delete
                                                echo "<td><a href='deleteFavorites.php?id=" . $row['anime_id'] . "&confirm=true' class='btn btn-danger me-2' onclick='return confirm(\"Are you sure you want to delete?\")'><i class='fa-solid fa-trash' style='color: #ffffff;'></i></a></td>";

                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<?php
// Close the database connection
mysqli_close($conn);
?>