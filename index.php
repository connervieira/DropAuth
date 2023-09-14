<?php
include "./config.php";
include "./utils.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?></title>
        <link href="./stylesheets/styles.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <h1><?php echo htmlspecialchars($config["branding"]["name"]); ?></h1>
            <h3><?php echo htmlspecialchars($config["branding"]["tagline"]); ?></h3>
            <br><hr><br><br>
            <a class="button" href="./signup.php">Sign Up</a>
            <a class="button" href="./signin.php">Sign In</a>
        </main>
    </body>
</html>
