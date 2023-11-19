<?php
session_start();

include("db_connection.php");
include("functions.php");

$user_data = check_login($conn);

if (isset($_GET['id'])) {
    $animeID = $_GET['id'];
    $username = $user_data['username'];
    $sourcePage = isset($_GET['source']) ? $_GET['source'] : 'unknown'; // Capture the source page or default to 'unknown'


    // Retrieving anime details based on the anime ID
    $animeDetailsUrl = "https://api.jikan.moe/v4/anime/$animeID";
    $animeDetailsResponse = file_get_contents($animeDetailsUrl);

    if ($animeDetailsResponse !== false) {
        $animeDetails = json_decode($animeDetailsResponse, true);

        if ($animeDetails && isset($animeDetails['data'])) {
            $title = $animeDetails['data']['title'];
            $synopsis = $animeDetails['data']['synopsis'];
            $type = $animeDetails['data']['type'];
            $episodes = $animeDetails['data']['episodes'];
            $status = $animeDetails['data']['status'];

            $query = "SELECT * FROM favorites WHERE username = '$username' AND anime_id = $animeID;";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) == 0) {
                $sqlInsert = "INSERT INTO favorites (anime_id, username, title, description, type, status, episodes) VALUES (?,?,?,?,?,?,?);";
                $stmt = $conn->prepare($sqlInsert);
                $stmt->bind_param("sssssss", $animeID, $username, $title, $synopsis, $type, $status, $episodes);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    header('Location: favorites.php');
                    exit;
                } else {
                    $_SESSION['message'] = "Failed to add anime to favorites";
                }
            } else {
                $_SESSION['message'] = "Anime already added in favorites";
            }
        } else {
            $_SESSION['message'] = "Anime details not found";
        }
    } else {
        $_SESSION['message'] = "Failed to fetch anime details from the API";
    }
}

// Redirect the user back to the previous page after processing if insertion was unsuccessful
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>