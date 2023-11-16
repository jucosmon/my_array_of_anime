<?php

// Checks if the user is logged in using a session variable
function check_login($conn)
{
    // Checks if 'username' is set in the session
    if (isset($_SESSION['username'])) {

        // Retrieves the username from the session
        $id = $_SESSION['username'];

        // Constructs a SQL query to select user data based on the username
        $query = "SELECT * FROM users WHERE username = '$id' LIMIT 1";

        // Executes the query using the provided database connection
        $result = mysqli_query($conn, $query);

        // If query executes successfully and returns at least one row
        if ($result && mysqli_num_rows($result) > 0) {

            // Fetches user data as an associative array
            $user_data = mysqli_fetch_assoc($result);

            // Returns the fetched user data
            return $user_data;
        }
    }

    // Redirects to 'signup page' if user not logged in or query fails
    header("Location: login.php");
    die; // Stops further execution after redirection
}


?>