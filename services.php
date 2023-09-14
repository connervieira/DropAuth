<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
include "./config.php";
include "./utils.php";

if (!in_array($username, $config["admin_users"])) { // Check to see if the current user is not an administrator.
    echo "<p>This tool is only available to administrators.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?> - Services</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <?php
            $service_database = load_database("service"); // Load the services database from disk.

            if (variable_exists($_POST["service_id"])) { // Check to see if the configuration form was submitted.
                load_database("service", $service_database);
            } else {
                echo '
                <div style="text-align:left;"><a class="button" href="./account.php">Back</a></div>
                <main>
                    <h1>Services</h1>
                    <h3>Manage services registered to interact with this ' . htmlspecialchars($config["branding"]["name"]) . ' instance</h3>
                    <br><br><hr><br>
                    <h2>Register</h2>
                    <form method="POST">
                        <label for="service_id">Service ID: </label><input placeholder="abc12345678" id="service_id" type="text" name="service_id" value="' . bin2hex(random_bytes(8)) . '"><br><br>
                        <label for="service_name">Service Name: </label><input placeholder="Friendly Name" id="service_name" type="text" name="service_name"><br><br>
                        <input class="button" type="submit">
                    </form>

                    <br><br><hr><br>
                    <h2>Revoke</h2>
                    <form method="POST">
                        <label for="service_id">Service ID: </label><input placeholder="abc12345678" id="service_id" type="text" name="service_id" value="' . $_GET["revoke_autofill"] . '"><br><br>
                        <input class="button" type="submit">
                    </form>

                    <br><br><hr><br>
                    <h2>View</h2>
                </main>
                ';
            }
            ?>
        </main>
    </body>
</html>
