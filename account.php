<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DropAuth - Account</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <h1>Account</h1>
            <h3>Manage your DropAuth account</h3>
            <br><hr><br><br>
            <a class="button" href="./signout.php">Sign Out</a>
            <a class="button" href="./changepassword.php">Change Password</a>
        </main>
    </body>
</html>
