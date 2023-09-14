<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
include "./config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?> - Account</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <h1>Account</h1>
            <h3>Manage your <?php echo htmlspecialchars($config["branding"]["name"]); ?> account</h3>
            <br><hr><br><br>
            <a class="button" href="./signout.php">Sign Out</a>
            <a class="button" href="./changepassword.php">Change Password</a>

            <?php
            if (in_array($username, $config["admin_users"])) { // Check to see if the current user is an administrator.
                echo "<br><br><br><a class=\"button\" href=\"./configure.php\">Configure</a>";
            }
            ?>
        </main>
    </body>
</html>
