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

  <title>Home Page</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand text-uppercase" href="#">My Array of Anime</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="#trending">Trending</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#recommendations">Recommendations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#facts">Facts</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>

      </div>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Watchlist
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
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
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
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </section>
    <section id="header-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="0" class="active" aria-current="true"
          aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active c-item">
          <img src="images/header4.jpg" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption top-0 mt-4">
            <p class="fs-3 mt-5 text-uppercase">Trending</p>
            <h1 class="display-1 fw-bolder text-capitalize">Attack on Titan</h1>
            <button class="btn btn-primary px-4 py-2 fs-5 mt-5" data-bs-toggle="modal"
              data-bs-target="#watchlist-modal">Add to Watchlist</button>
          </div>
        </div>
        <div class="carousel-item c-item">
          <img src="images/header2.jpg" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption top-0 mt-4">
            <p class="fs-3 mt-5 text-uppercase">Trending</p>
            <h1 class="display-1 fw-bolder text-capitalize">One Piece</h1>
            <button class="btn btn-primary px-4 py-2 fs-5 mt-5" data-bs-toggle="modal"
              data-bs-target="#watchlist-modal">Add to Watchlist</button>
          </div>
        </div>
        <div class="carousel-item c-item">
          <img src="images/header3.jpg" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption top-0 mt-4">
            <p class="fs-3 mt-5 text-uppercase">Trending</p>
            <h1 class="display-1 fw-bolder text-capitalize">Naruto</h1>
            <button class="btn btn-primary px-4 py-2 fs-5 mt-5" data-bs-toggle="modal"
              data-bs-target="#watchlist-modal">Add to Watchlist</button>
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


    <section id="trending" class="pt-md-5">
      <h2 class="text-center my-5">Trending</h2>
      <div class="container">
        <div class="row">
          <div class="col-lg">
            <div class="card"">
            <img src=" images/header4.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">FairyTale</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus aspernatur dolor
                  sequi sit nisi fuga laborum dignissimos.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#watchlist-modal">Add to
                  Watchlist</button>
              </div>
            </div>
          </div>
          <div class="col-lg">
            <div class="card"">
            <img src=" images/header2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">One Piece</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus aspernatur dolor
                  sequi sit nisi fuga laborum dignissimos.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#watchlist-modal">Add to
                  Watchlist</button>
              </div>
            </div>

          </div>
          <div class="col-lg">
            <div class="card"">
            <img src=" images/header3.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Naruto</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus aspernatur dolor
                  sequi sit nisi fuga laborum dignissimos.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#watchlist-modal">Add to
                  Watchlist</button>
              </div>
            </div>

          </div>
        </div>
      </div>


    </section>
    <section id="recommendations" class="pt-md-5">
      <h2 class="text-center my-5">Recommendations</h2>
      <div class="container">
        <div class="row">
          <div class="col-lg">
            <div class="card"">
            <img src=" images/header4.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">FairyTale</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus aspernatur dolor
                  sequi sit nisi fuga laborum dignissimos.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#watchlist-modal">Add to
                  Watchlist</button>
              </div>
            </div>
          </div>
          <div class="col-lg">
            <div class="card"">
            <img src=" images/header2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">One Piece</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus aspernatur dolor
                  sequi sit nisi fuga laborum dignissimos.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#watchlist-modal">Add to
                  Watchlist</button>
              </div>
            </div>

          </div>
          <div class="col-lg">
            <div class="card"">
            <img src=" images/header3.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Naruto</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus aspernatur dolor
                  sequi sit nisi fuga laborum dignissimos.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#watchlist-modal">Add to
                  Watchlist</button>
              </div>
            </div>

          </div>
        </div>
      </div>


    </section>

    <section id="facts" class="py-md-5">
      <h2 class="my-5 text-center">Facts</h2>
      <div class="container">
        <div class="accordion w-75 mx-auto" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                Accordion Item #1
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
                plugin adds the appropriate classes that we use to style each element. These classes control the overall
                appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Accordion Item #2
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse
                plugin adds the appropriate classes that we use to style each element. These classes control the overall
                appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Accordion Item #3
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
              data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse
                plugin adds the appropriate classes that we use to style each element. These classes control the overall
                appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                within the <code>.accordion-body</code>, though the transition does limit overflow.
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

  <footer class="bg-dark py-5 mt-5">
    <div class="container text-light text-center">
      <p class="display-6 mb-4">
        My Array of Anime
      </p>
      <small class="text-white-50">
        Copyright by Strawberry-1. All rights reserved.
      </small>
    </div>
  </footer>

</body>

</html>