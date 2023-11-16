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

// Create the database if it doesn't already exist
$database = "my_anime_of_anime_db";
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sqlCreateDB) === TRUE) {
    error_log("Databaase created successfully"); //  success message
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($database); // Select the specified database

// Create the 'users' table if it doesn't already exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
                    username VARCHAR(80) PRIMARY KEY,
                    password VARCHAR(80) NOT NULL,
                    date_of_birth DATE
                )";
if ($conn->query($sqlCreateTable) === TRUE) {
    error_log("Table created successfully"); //  success message
} else {
    die("Error creating table: " . $conn->error);
}

?>