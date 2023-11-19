<?php
session_start();
include("db_connection.php");
include("functions.php");

$user_data = check_login($conn);
$username = $user_data['username'];

if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = $_GET['id'];


    $query = "DELETE FROM favorites WHERE username='$username' AND anime_id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: favorites.php");
        exit;
    } else {
        die("Error occurred during deletion.");
    }
} else {
    die("No ID specified.");
}
