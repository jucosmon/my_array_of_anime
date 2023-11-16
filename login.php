<?php
session_start();
include("db_connection.php"); // Include the file containing the database connection
include("functions.php");

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  //asigning sa username nga gi input sa user sa variable
  $username = $_POST['username'];
  $password = $_POST['pass'];

  if (!empty($username) && !is_numeric($username)) {

    //READ  DATABASE
    $query = "Select * from users where username = '$username' limit 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
      if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        if ($user_data['username'] === $username && $user_data['password'] === $password) {
          $_SESSION['username'] = $user_data['username'];
          header("Location: index.php");
          die;
        }
      }
    }
    $errorMessage = "Wrong username or password";
  } else {
    $errorMessage = "Please enter some valid information!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" n$conntent="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.2/css/bootstrap-grid.min.css" />
  <title>Sign in</title>
</head>

<body>
  <div class="wrapper">
    <div class="text-center">
      <p class="mx-auto" style="width: 300px;">
        <?php echo $errorMessage; ?>
      </p>
    </div>
    <div class="container main">
      <div class="row">
        <div class="col-md-6 side-image">
          <!-------------      image     ------------->
          <img class="logo-img" src="images/array.png" alt="" />
          <div class="text">
            <p>My Arrray of Anime <i>Strawberry-1</i></p>
          </div>
        </div>
        <div class="col-md-6 right">
          <div class="input-box">
            <header>Welcome Back</header>
            <form action="login.php" method="POST">
              <div class="input-field">
                <input type="text" class="input" id="username" name="username" required="" />
                <label for="username">Username</label>
              </div>
              <div class="input-field">
                <input type="password" class="input" id="pass" name="pass" required="" />
                <label for="pass">Password</label>
              </div>
              <div class="input-field">
                <input type="submit" class="submit" value="Sign in" />
              </div>
            </form>
            <div class="signin">
              <span> <a href="signup.php">Create Account</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>