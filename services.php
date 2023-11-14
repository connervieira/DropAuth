<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
include (dirname(__FILE__) . "/config.php");
include (dirname(__FILE__) . "/utils.php");

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


            if ($_POST["register"] == "Submit") { // Check to see if the registration form was submitted.
                echo "<div style=\"text-align:left;\"><a class=\"button\" href=\"./services.php\">Back</a></div>";

                // Collect all inputs.
                $service_id = $_POST["service_id"];
                $service_name = $_POST["service_name"];

                // Validate and sanitize all inputs.
                if ($service_id !== preg_replace("/[^a-zA-Z0-9_\-]/", '', $service_id)) {
                    echo "<p class=\"error\">The Service ID can only contain numbers, letters, underscores, and hyphens.</p>"; exit();
                }
                if ($service_name !== preg_replace("/[^a-zA-Z0-9_\-\ ]/", '', $service_name)) {
                    echo "<p class=\"error\">The Service Name can only contain numbers, letters, underscores, hyphens, and spaces.</p>"; exit();
                }


                // Add the service to the database.
                if (!isset($service_database[$service_id])) { // Check to see if the data stored by this service doesn't already exist.
                    $service_database[$service_id] = array();
                }

                if (strval($service_name) !== "" and isset($service_name) == true) {
                    $service_database[$service_id]["info"]["name"] = $service_name; // Record the name of this service, as set by the user.
                } else if (isset($service_database[$service_id]["info"]["name"]) == false or $service_database[$service_id]["info"]["name"] == "") {
                    $service_database[$service_id]["info"]["name"] = "No Name";
                }
                if (isset($service_database[$service_id]["info"]["registered"]["user"]) == false) { // Only update the user who registered this service if it does not already exist.
                    $service_database[$service_id]["info"]["registered"]["user"] = $username; // Record the username of the user who registered this service.
                }
                $service_database[$service_id]["info"]["updated"]["user"] = $username; // Record the username of the user who updated this service.
                if (isset($service_database[$service_id]["info"]["registered"]["time"]) == false) { // Only update the user who registered this service if it does not already exist.
                    $service_database[$service_id]["info"]["registered"]["time"] = time(); // Record the time that this service was registered.
                }
                $service_database[$service_id]["info"]["updated"]["time"] = time(); // Record the time that this service was updated.
                if (!isset($service_database[$service_id]["data"]["main"]["active"])) { // Check to see if the data stored by this service doesn't already exist.
                    $service_database[$service_id]["data"]["main"]["active"] = array(); // Add a placeholder where this service will store it's data.
                }

                // Save the updated service database to disk.
                save_database("service", $service_database);
                echo "<p>Successfully registered service.</p>";
            } else if ($_POST["revoke"] == "Submit") { // Check to see if the revokation form was submitted.
                echo "<div style=\"text-align:left;\"><a class=\"button\" href=\"./services.php\">Back</a></div>";

                $service_id = $_POST["service_id"];

                if (in_array($service_id , array_keys($service_database))) { // Check to make sure the specified service ID actually exists in the database.
                    unset($service_database[$service_id]); // Remove the specified service ID from the service database.
                    save_database("service", $service_database); // Save the modified service database to disk.
                    echo "<p>Successfully revoked service.</p>";
                } else { // Otherwise, the specified service ID does not exist in the database.
                    echo "<p class=\"error\">The specified service ID does not exist in the database.</p>";
                }
            } else {
                echo '
                <div style="text-align:left;"><a class="button" href="./account.php">Back</a></div>
                <main>
                    <h1>Services</h1>
                    <h3>Manage services registered to interact with this ' . htmlspecialchars($config["branding"]["name"]) . ' instance</h3>
                    <br><br><hr><br>
                    <h2>Register</h2>
                    <form method="POST">
                        <label for="service_id">Service ID: </label><input placeholder="service_identifier" id="service_id" type="text" name="service_id" value="' . $_GET["service_id_autofill"] . '"><br><br>
                        <label for="service_name">Service Name: </label><input placeholder="Friendly Name" id="service_name" type="text" name="service_name"><br><br>
                        <input class="button" name="register" id="register" value="Submit" type="submit">
                    </form>

                    <br><br><hr><br>
                    <h2>Revoke</h2>
                    <form method="POST">
                        <label for="service_id">Service ID: </label><input placeholder="service_identifier" id="service_id" type="text" name="service_id" value="' . $_GET["service_id_autofill"] . '"><br><br>
                        <input class="button" name="revoke" id="revoke" value="Submit" type="submit">
                    </form>

                    <br><br><hr><br>
                    <h2>View</h2>
                    ';
                foreach (array_keys($service_database) as $service) {
                    echo "<div class=\"box\">";
                    echo "<a href=\"?service_id_autofill=" . $service . "\"><h3>" . $service . " - " . $service_database[$service]["info"]["name"] . "</h3></a>";
                    echo "</div>";
                }
                echo '
                </main>
                ';
            }
            ?>
        </main>
    </body>
</html>
