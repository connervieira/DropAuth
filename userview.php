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
                <a class="button" href="./userlist.php">Back</a>
            </div>
            <h1>User - View</h1>
            <h3>View all information associated with a given account</h3>
            <br><hr><br>

            <?php
            $user_to_view = $_GET["user"];
            $account_database = load_database("account");
            $account_information = $account_database[$user_to_view];

            $account_information["password"] = "###################"; // Censor the password field in the account information before displaying.

            echo "<h4>" . $user_to_view ."</h4>";

            echo "<pre>";
            print_r($account_information);
            echo "</pre>";
            ?>
        </main>
    </body>
</html>
