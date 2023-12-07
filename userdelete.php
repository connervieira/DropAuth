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
            <h1>User - Delete</h1>
            <h3>Delete a given <?php echo htmlspecialchars($config["branding"]["name"]); ?> account</h3>
            <br><hr><br>

            <?php
            $user_to_delete = $_GET["user"];
            $account_database = load_database("account");

            if ($username == $user_to_delete) {
                echo "<p class='error'>Error: You are currently signed in as the user you are trying to delete.</p>";
                exit();
            }


            if (time() - floatval($_GET["confirmation"]) < 0) {
                echo "<p>The confirmation timestamp is in the future. If you clicked an external link to get here, it is possible that someone is trying to manipulate you into deleting a " . htmlspecialchars($config["branding"]["name"]) . " account. No accounts have been affected.</p>";
            } else if (time() - floatval($_GET["confirmation"]) < 15) {
                if (delete_account($user_to_delete)) { // Delete the account.
                    echo "<p class='success'>Successfully deleted account.</p>";
                } else {
                    echo "<p class='error'>Account deletion failed.</p>";
                }
            } else {
                echo "<p>Are you sure you want to delete the account '<b>" . $user_to_delete . "</b>'?</p>";
                echo "<a class=\"button\" href=\"?user=" . $user_to_delete . "&confirmation=" . time() . "\">Confirm Deletion</a>";
            }
            ?>
        </main>
    </body>
</html>
