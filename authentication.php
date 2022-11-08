<?php
session_start(); // Start a PHP session.
if (isset($_SESSION['loggedin'])) { // Check to see if the user is already signed in.
    $username = $_SESSION["username"];
} else {
    if ($force_login_redirect == true) {
        header("Location: /dropauth/signin.php");
        exit();
    }
}
?>
