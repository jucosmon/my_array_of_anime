<?php
session_start();

include("db_connection.php"); // Include the file containing the database connection
include("functions.php"); //stores username data

$user_data = check_login($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '1';

    echo $_POST['animeID'] . $_POST['watchlistOption'];

    if (isset($_POST['animeID'], $_POST['watchlistOption'])) {
        echo '2';
        //variables
        $animeID = $_POST['animeID'];
        $watchlistOption = $_POST['watchlistOption'];
        $username = $user_data['username'];

        //retrieving anime titles depende sa anime id
        $animeDetailsUrl = "https://api.jikan.moe/v4/anime/$animeID";
        $animeDetailsResponse = file_get_contents($animeDetailsUrl);

        if ($animeDetailsResponse !== false) {
            // Decode JSON response
            $animeDetails = json_decode($animeDetailsResponse, true);

            if ($animeDetails && isset($animeDetails['data'])) {
                // Extract and store attributes from the data
                $title = $animeDetails['data']['title'];
                $synopsis = $animeDetails['data']['synopsis'];
                $type = $animeDetails['data']['type'];
                $episodes = $animeDetails['data']['episodes'];
                $status = $animeDetails['data']['status'];

            } else {
                echo "Anime details not found.";
            }
        } else {
            echo "Failed to fetch anime details from the API.";
        }

        // Checking if the username and anime if it already exists in the database
        $query = "SELECT * FROM animelist WHERE username = '$username' AND anime_id = $animeID; ";
        $result = mysqli_query($conn, $query);

        //if ang result sa query kay walay ning exist nga animeid sa usa ka user then valid 
        if ($result && mysqli_num_rows($result) == 0) {

            // Prepare and execute a secure insertion query using prepared statements
            $sqlInsert = "INSERT INTO animelist (anime_id, username, title, description, type, status, episodes, Category) VALUES (?,?,?,?,?,?,?,?);";
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bind_param("ssssssss", $animeID, $username, $title, $synopsis, $type, $status, $episodes, $watchlistOption);
            $stmt->execute();

            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                error_log("New record inserted successfully"); //  success message
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            $_SESSION['message'] = "Anime already exists in the database";

            error_log("Anime already exist on database"); //if invalid ang username

        }

        // Redirect the user back to the previous page after processing
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    var_dump($_POST);
}
?>