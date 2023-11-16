<?php
session_start();
include("db_connection.php");
include("functions.php");

$user_data = check_login($conn);
$username = $user_data['username'];
$newUsername = $_POST['username'];
$password = $user_data['password'];
$newPassword = $_POST['password'];
$birthdate = $user_data['date_of_birth'];
$newBirthdate = $_POST['birthdate'];


try {
    if ($username == $newUsername && ($password != $newPassword || $birthdate != $newBirthdate)) {
        // Update the password in the database
        $query = "UPDATE users SET password ='$newPassword',date_of_birth ='$newBirthdate' WHERE username = '$username' ";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: profile.php");
            die;
        } else {
            throw new Exception("Error updating password: " . mysqli_error($conn));
        }
    } else {
        // Check if the new username already exists
        $query = "SELECT * FROM users WHERE username = '$newUsername'";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            echo "<br><a href=" . 'account.php' . ">Go back</a>";
            echo "<br><br><center>Sorry <b>$newUsername</b> already exists :< </center>";
            echo "<br><br><center><a href=" . 'editProfile.php' . ">Enter again </a></center>";
        } else {
            // Update the profile in the database
            $query = "UPDATE users SET username = '$newUsername', password ='$newPassword', date_of_birth = '$newBirthdate' WHERE username = '$username' ";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $_SESSION['username'] = $newUsername;
                header("Location: profile.php");
                die;
            } else {
                throw new Exception("Error updating profile: " . mysqli_error($conn));
            }
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}