<?php
session_start();
include("db_connection.php"); // Include the file containing the database connection
include("functions.php");
// checking if nalog in naba ang user
$user_data = check_login($conn);

//getting top anime database using jikan api and extracting it
$url = 'https://api.jikan.moe/v4/top/anime';
$data = file_get_contents($url);
$jsonData = json_decode($data, true);

if ($jsonData && isset($jsonData['data'])) {
  $topAnime = $jsonData['data'];

  $displayAnime = [];
  $count = 0;
  foreach ($topAnime as $anime) {
    $displayAnime[] = [
      'id' => $anime['mal_id'],
      'title' => $anime['title'],
      'url' => $anime['url'],
      'score' => $anime['score'],
      'episodes' => $anime['episodes'],
      'status' => $anime['status'],
      'synopsis' => $anime['synopsis'],
      'image_url' => $anime['images']['jpg']['large_image_url']

    ];
    //limitahan ug 6 kay lain sad ibutang 200 results, taas ra kaaayo
    $count++;
    if ($count >= 6) {
      break;
    }
  }
} else {
  echo 'Failed to fetch data.';
}

//getting recommendations anime data using jikan api 
$urlrec = "https://api.jikan.moe/v4/recommendations/anime";
$recjson = file_get_contents($urlrec);

// Decode JSON data
$recData = json_decode($recjson, true);

// Create an array to store recommendation anime data
$recommendationAnime = [];

// Counter from 0 to limit to 15 recommendations
$recommendationCount = 0;

// Extract anime titles and image URLs (limit to 15 recommendations) ug i store sa array para magamit sa ubos code
foreach ($recData['data'] as $recommendation) {
  foreach ($recommendation['entry'] as $entry) {
    $recommendationAnime[] = [
      'id' => $entry['mal_id'],
      'title' => $entry['title'],
      'content' => $recommendation['content'],
      'image_url' => $entry['images']['jpg']['large_image_url']
    ];

    // Increment counter
    $recommendationCount++;

    // Break the loop after storing 15 anime details sa recommendations
    if ($recommendationCount === 15) {
      break 2; // Break both foreach loops since 2 forloops angin sa structure sa data
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
            <input class="form-control me-2" name="searchname" type="search" placeholder="Search" aria-label="Search"
              required>
            <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"
                style="color: #ffffff;"></i></button>
          </form>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <!-- ag carousel sa babaw homepage -->
    <section id="header-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="0" class="active" aria-current="true"
          aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active c-item">
          <img src="<?php echo $displayAnime[0]['image_url']; ?>" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption top-0 mt-4">
            <p class="fs-3 mt-5 text-uppercase">Trending</p>
            <h1 class="display-1 fw-bolder text-capitalize">
              <?php echo $displayAnime[0]['title']; ?>
            </h1>
            <button class="btn btn-primary px-4 py-2 fs-5 mt-5" id="c-button" data-bs-toggle="modal"
              data-bs-target="#watchlist-modal" data-animeID="<?php echo $displayAnime[0]['id']; ?>">Add to
              Watchlist</i>
            </button>
          </div>
        </div>

        <div class="carousel-item c-item">
          <img src="<?php echo $displayAnime[1]['image_url']; ?>" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption top-0 mt-4">
            <p class="fs-3 mt-5 text-uppercase">Trending</p>
            <h1 class="display-1 fw-bolder text-capitalize">
              <?php echo $displayAnime[1]['title']; ?>
            </h1>
            <button class="btn btn-primary px-4 py-2 fs-5 mt-5" id="c-button" data-bs-toggle="modal"
              data-bs-target="#watchlist-modal" data-animeID="<?php echo $displayAnime[1]['id']; ?>">Add to
              Watchlist</i>
            </button>
          </div>
        </div>
        <div class="carousel-item c-item">
          <img src="<?php echo $displayAnime[2]['image_url']; ?>" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption top-0 mt-4">
            <p class="fs-3 mt-5 text-uppercase">Trending</p>
            <h1 class="display-1 fw-bolder text-capitalize">
              <?php echo $displayAnime[2]['title']; ?>
            </h1>
            <button class="btn btn-primary px-4 py-2 fs-5 mt-5" id="c-button" data-bs-toggle="modal"
              data-bs-target="#watchlist-modal" data-animeID="<?php echo $displayAnime[2]['id']; ?>">Add to
              Watchlist</i>
            </button>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </section>

    <!-- trending section -->
    <section id="trending" class="pt-md-5">
      <h2 class="text-center my-5">Trending</h2>
      <div class="container">
        <div class="row gy-3">

          <!-- displaying sa card depende ug pila ag sulod s displayAnime -->
          <?php foreach ($displayAnime as $anime): ?>
            <div class="col-lg-4">
              <div class="card h-100 c-card">
                <div style="height: 200px; overflow: hidden;">
                  <img src="<?php echo $anime['image_url']; ?>" class="card-img-top img-fluid card-image"
                    style="height: 100%; object-fit: cover;" alt="Anime Image">
                </div>
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo $anime['title']; ?>
                  </h5>
                  <p class="card-text" style="height: 90px; overflow: hidden;">
                    <?php echo substr($anime['synopsis'], 0, 100); ?>
                    <?php echo strlen($anime['synopsis']) > 100 ? '...' : ''; ?>
                  </p>
                  <div class="mt-auto d-flex justify-content-end">
                    <a href="insertFavorites.php?id=<?php echo $anime['id']; ?>" class="btn btn-primary me-2"
                      id="c-button"><i class="fa-solid fa-heart" style="color: #ffffff;"></i></a>
                    <a href="animeDetails.php?id=<?php echo $anime['id']; ?>" class="btn btn-primary me-2"
                      id="c-button"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>
                    <button class="btn btn-primary" id="c-button" data-bs-toggle="modal" data-bs-target="#watchlist-modal"
                      data-animeID="<?php echo $anime['id']; ?>">
                      <i class=" fa-solid fa-bookmark" style="color: #f2f2f2;"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- recommendations section -->
    <section id="recommendations" class="pt-md-5">
      <h2 class="text-center my-5">Recommendations</h2>
      <div class="container">
        <div class="row gy-3">
          <!-- displaying sa card depende ug pila ag sulod s recommendationAnime -->
          <?php foreach ($recommendationAnime as $anime2): ?>
            <div class="col-lg-4">
              <div class="card h-100 c-card">
                <div style="height: 200px; overflow: hidden;">
                  <img src="<?php echo $anime2['image_url']; ?>" class="card-img-top img-fluid card-image"
                    style="height: 100%; object-fit: cover;" alt="Anime Image">
                </div>
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo $anime2['title']; ?>
                  </h5>
                  <p class="card-text" style="height: 90px; overflow: hidden;">
                    <?php echo substr($anime2['content'], 0, 100); ?>
                    <?php echo strlen($anime2['content']) > 100 ? '...' : ''; ?>
                  </p>
                  <div class="mt-auto d-flex justify-content-end">
                    <a href="insertFavorites.php?id=<?php echo $anime['id']; ?>" class="btn btn-primary me-2"
                      id="c-button"><i class="fa-solid fa-heart" style="color: #ffffff;"></i></a>
                    <a href="animeDetails.php?id=<?php echo $anime2['id']; ?>" class="btn btn-primary me-2"
                      id="c-button"><i class="fa-solid fa-eye" style="color: #ffffff;"></i></a>
                    <button class="btn btn-primary" id="c-button" data-bs-toggle="modal" data-bs-target="#watchlist-modal"
                      data-animeID="<?php echo $anime2['id']; ?>">
                      <i class=" fa-solid fa-bookmark" style="color: #f2f2f2;"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>
    </section>

    <!-- facts section-->
    <section id="about" class="py-md-5">
      <h2 class="my-5 text-center">About us</h2>
      <div class="container">
        <div class="accordion w-75 mx-auto" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" id="c-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                My Array of Anime
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>Introducing a user-friendly web app for anime
                  enthusiasts.</strong> Discover and explore information about any anime you desire, add them to your
                watchlist,
                and track your progress. Sign up or log in to access the features. With our platform, you can easily
                keep track of the anime series you're watching, create a collection of your favorites, and stay
                organized. Dive into the world of anime and elevate your watching experience with our user-friendly
                interface.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" id="c-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Developers
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>Strawberry-1</strong>
                <ul>
                  <li>Zachary Albert Legaria</li>
                  <li>Jelah Marie Dango</li>
                  <li>Rezelle June Udtohan</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" id="c-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Why our name is My Array of Anime?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Our website gets its name from the coding term <strong>"Array,"</strong> which represents a collection
                of elements.
                <code>My Array of Anime</code> focuses on providing a comprehensive watchlist experience for anime
                fans. Similar to
                how elements are organized efficiently in coding arrays, our platform allows users to create and manage
                personalized watchlists for anime series. We bring together the organizational aspect of coding with the
                captivating world of anime with the name of our website. The name <code>"My Array of Anime"</code>
                reflects our
                passion in <code>coding</code> and anime content.


              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- tried using icons in bootstrap
    <section class="overview">
      <div class="container h-100 d-flex align-items-center">
        <div class="row w-100 text-center fs-4">
          <div class="col-xl">
            <i class="bi bi-airplane-fill me-2"></i>
            Cool Airplane
          </div>
          <div class="col-xl">
            <i class="bi bi-wallet-fill me-2"></i>
            This is 100% free
          </div>
          <div class="col-xl">
            <i class="bi bi-patch-check-fill me-2"></i>
            1000's of customers
          </div>
        </div>
      </div>
    </section>
-->
  </main>

  <footer class=" py-5 mt-5">
    <div class="container text-light text-center">
      <p class="display-6 mb-4">
        My Array of Anime
      </p>
      <small class="text-white-50">
        Copyright by Strawberry-1. All rights reserved.
      </small>
    </div>
  </footer>
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