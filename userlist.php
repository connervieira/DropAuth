<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
include "./config.php";
include "./utils.php";

if (!in_array($username, $config["admin_users"])) { // Check to see if the current user is an administrator.
    echo "<p>This page is accessible only to administrators.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?> - User View</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <div class="navbar" role="navbar">
                <a class="button" href="./account.php">Back</a>
            </div>
            <h1>User - View</h1>
            <h3>View and manage <?php echo htmlspecialchars($config["branding"]["name"]); ?> accounts</h3>
            <br><hr><br>

            <?php
            $account_database = load_database("account");
            foreach ($account_database as $username => $account_info) {
                echo "<br><br><p>" . $username . "</p>";
                echo "<a class=\"button\" href=\"./userview.php?user=" . $username . "\">View</a> ";
                echo "<a class=\"button\" href=\"./userdelete.php?user=" . $username . "\">Delete</a>";
            }
            ?>
        </main>
    </body>
</html>
