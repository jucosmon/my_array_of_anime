<?php
// Default xampp deets
$host = "localhost";
$username = "root";
$password = "";

// Create a connection
$conn = new mysqli($host, $username, $password);

// Check the connection, kapoy try catch
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it does not exist
$database = "my_anime_of_anime_db";
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $database";

if ($conn->query($sqlCreateDB) === TRUE) {
    // if na execute ang query nga create database, yeah
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// similar to 'use my_anime_of_anime_db
$conn->select_db($database);

// Create the users table if it does not exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    date_of_birth DATE
                )";

if ($conn->query($sqlCreateTable) === TRUE) {
    echo "Table created successfully<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered data
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["pass"];
    $enteredDateOfBirth = $_POST["date"];

    // Insert data into the users table
    $sqlInsert = "INSERT INTO users (username, password, date_of_birth) VALUES ('$enteredUsername', '$enteredPassword', '$enteredDateOfBirth')";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $sqlInsert . "<br>" . $conn->error;
    }
}

// Display entered username and password
if (isset($enteredUsername) && isset($enteredPassword)) {
    // i checks if variable is set and is not null
    echo "Entered Username: " . $enteredUsername . "<br>";
    echo "Entered Password: " . $enteredPassword . "<br>";
    echo "Entered Date of Birth: " . $enteredDateOfBirth . "<br>";
}

// Close the database connection
$conn->close();
?>
