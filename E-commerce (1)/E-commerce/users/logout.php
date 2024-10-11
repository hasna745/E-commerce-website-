<?php
session_start(); // Start or resume the session

// Check if the user is logged in
if(!empty($_SESSION['username'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to the home page or any other page after logout
    header("Location: ../home.php");
    exit();
} else {
    // If the user is not logged in, redirect them to the home page or any other page
    header("Location: ../home.php");
    exit();
}
?>
