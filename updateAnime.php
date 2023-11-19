<?php
session_start();
include("db_connection.php");
include("functions.php");

$user_data = check_login($conn);
$username = $user_data['username'];

if (isset($_GET['id']) && isset($_GET['prev']) && isset($_GET['next'])) {
    $id = $_GET['id'];
    $prev = $_GET['prev'];
    $next = $_GET['next'];

    //queries
    $query = "UPDATE animelist SET Category = '$next' WHERE username = '$username' AND Category='$prev' AND anime_id = '$id';";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if ($_GET['next'] == 'to_watch') {
            header('Location: towatchlist.php');
        } else if ($_GET['next'] == 'in_progress') {
            header('Location: ongoingList.php');
        } else {
            header('Location: finishedList.php');
        }
        exit;
    } else {
        die("Error occurred during deletion.");

    }
}