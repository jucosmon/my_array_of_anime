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
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.2/css/bootstrap-grid.min.css" />
  <title>Home Page</title>
</head>

<body></body>

</html>