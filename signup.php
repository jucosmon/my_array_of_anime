<?php
include("db_connection.php"); // Include the file containing the database connection

//for displaying the invalid data entered on the html body so if wala pa nakasignup it should be empty
$errorMessage = "";

// if iclick na ang sign up button sa form
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // assigning the inputted values into a variable
  $username = $_POST["username"];
  $enteredPassword = $_POST["pass"];
  $enteredDateOfBirth = $_POST["date"];

  // Checking if the username already exists in the database
  $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
  $result = mysqli_query($conn, $query);

  //if ang result sa query kay walay ning exist nga username then valid 
  if ($result && mysqli_num_rows($result) == 0) {

    // Prepare and execute a secure insertion query using prepared statements
    $sqlInsert = "INSERT INTO users (username, password, date_of_birth) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("sss", $username, $enteredPassword, $enteredDateOfBirth);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
      error_log("New record inserted successfully"); //  success message
      header("Location: login.php"); // Redirect to the login page
      exit(); // Stop further execution
    } else {
      echo "Error: " . $stmt->error;
    }
  } else {
    $errorMessage = "That username already exists"; //if invalid ang username
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.2/css/bootstrap-grid.min.css" />
  <title>Create Account</title>
</head>

<body>

  <div class="wrapper">
    <div class="text-center"> <!-- Center content within the div -->
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
            <header>Create Account</header>
            <form method="post" action="signup.php">
              <div class="input-field">
                <input type="text" class="input" name="username" id="username" required="" autocomplete="off" />
                <label for="username">Username</label>
              </div>
              <div class="input-field">
                <input type="password" class="input" name="pass" id="pass" required="" />
                <label for="pass">Password</label>
              </div>

              <div class="input-field">
                <input type="date" class="input" name="date" id="date" required="" />
                <label for="date">Birthday</label>
              </div>
              <div class="input-field">
                <input type="submit" class="submit" value="Sign Up" />
              </div>
            </form>
            <div class="signin">
              <span> <a href="login.php">Already have an account?</a></span>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</body>

</html>