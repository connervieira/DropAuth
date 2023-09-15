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
                echo "<div style=\"text-align:left;\"><a class=\"button\" href=\"./services.php\">Back</a></div>";

                // Collect all inputs.
                $service_id = $_POST["service_id"];
                $service_key = $_POST["service_key"];
                $service_name = $_POST["service_name"];

                // Validate and sanitize all inputs.
                if ($service_id !== preg_replace("/[^a-zA-Z0-9_\-]/", '', $service_id)) {
                    echo "<p class=\"error\">The Service ID can only contain numbers, letters, underscores, and hyphens.</p>"; exit();
                }
                if ($service_key !== preg_replace("/[^a-zA-Z0-9]/", '', $service_key)) {
                    echo "<p class=\"error\">The Service Key can only contain numbers and letters.</p>"; exit();
                }
                if ($service_name !== preg_replace("/[^a-zA-Z0-9_\-\ ]/", '', $service_name)) {
                    echo "<p class=\"error\">The Service Name can only contain numbers, letters, underscores, hyphens, and spaces.</p>"; exit();
                }

                // Add the service to the database.
                $service_database[$service_id] = array();
                $service_database[$_POST["service_id"]]["authentication"]["key"] = $_POST["service_key"];
                $service_database[$_POST["service_id"]]["info"]["name"] = $_POST["service_name"];
                $service_database[$_POST["service_id"]]["info"]["registered"]["user"] = $username;
                $service_database[$_POST["service_id"]]["info"]["registered"]["time"] = time();

                // Save the updated service database to disk.
                save_database("service", $service_database);
            } else {
                echo '
                <div style="text-align:left;"><a class="button" href="./account.php">Back</a></div>
                <main>
                    <h1>Services</h1>
                    <h3>Manage services registered to interact with this ' . htmlspecialchars($config["branding"]["name"]) . ' instance</h3>
                    <br><br><hr><br>
                    <h2>Register</h2>
                    <form method="POST">
                        <label for="service_id">Service ID: </label><input placeholder="service_identifier" id="service_id" type="text" name="service_id"><br><br>
                        <label for="service_key">Service Key: </label><input placeholder="abc12345678" id="service_key" type="text" name="service_key" value="' . bin2hex(random_bytes(8)) . '"><br><br>
                        <label for="service_name">Service Name: </label><input placeholder="Friendly Name" id="service_name" type="text" name="service_name"><br><br>
                        <input class="button" type="submit">
                    </form>

                    <br><br><hr><br>
                    <h2>Revoke</h2>
                    <form method="POST">
                        <label for="service_id">Service ID: </label><input placeholder="service_identifier" id="service_id" type="text" name="service_id" value="' . $_GET["revoke_autofill"] . '"><br><br>
                        <input class="button" type="submit">
                    </form>

                    <br><br><hr><br>
                    <h2>View</h2>
                    ';
                    // TODO: Display existing registered services.
                echo '
                </main>
                ';
            }
            ?>
        </main>
    </body>
</html>
