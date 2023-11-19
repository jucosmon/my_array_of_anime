<?php
session_start();
include("db_connection.php"); // Include the file containing the database connection
include("functions.php");

$user_data = check_login($conn);
$username = $user_data['username'];

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {

    $query = "delete from users where username='$username'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: signup.php");
        die;
    } else {
        die("Error occurred during deletion.");
    }
} else {
    die("Canceled deletion");
}