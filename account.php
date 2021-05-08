<!DOCTYPE html>
<?php
session_start(); // Start a PHP session.
if (isset($_SESSION['loggedin'])) { // Check to see if the user is already signed in.
    $username = $_SESSION["username"];
} else {
    header("Location: ./signin.php");
}
?>
<html lang="en">
    <head>
        <title>Journey - Account</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <h1>Account</h1>
        <a class="button" href="./signout.php">Sign Out</a>
    </body>
</html>
