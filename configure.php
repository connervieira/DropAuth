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
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?> - Configure</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <?php
            if ($_POST["submit"] == "Submit") { // Check to see if the configuration form was submitted.
                $config["databases"]["account"] = $_POST["databases>account"];
                $config["databases"]["service"] = $_POST["databases>service"];

                if ($_POST["allow_signups"] == "on") { $config["allow_signups"] = true;
                } else { $config["allow_signups"] = false; }


                $config["admin_users"] = explode(",", $_POST["admin_users"]); // Explode the list of admin users submitted into an array.
                foreach ($config["admin_users"] as $key => $user) { // Iterate through all users in the list of admin users.
                    $config["admin_users"][$key] = trim($user); // Trim any leading or trailing blank spaces for each user.
                    if ($config["admin_users"][$key] == "") { // Check to see if this entry is empty.
                        unset($$config["admin_users"][$key]); // Remove this entry.
                    }
                }


                if (is_writable($config_database_name)) { // Check to make sure the configuration file is writable.
                    file_put_contents($config_database_name, serialize($config)); // Save the modified configuration to disk.
                    echo '<div style="text-align:left;"><a class="button" href="./configure.php">Back</a></div>';
                    echo "<p>Successfully updated configuration.</p>";
                    exit();
                } else {
                    echo '<div style="text-align:left;"><a class="button" href="./configure.php">Back</a></div>';
                    echo "<p class='error'>The configuration file is not writable.</p>";
                    exit();
                }
            } else {
                echo '
                <div style="text-align:left;"><a class="button" href="./account.php">Back</a></div>
                <main>
                    <h1>Configure</h1>
                    <h3>Change the configuration of this ' . htmlspecialchars($config["branding"]["name"]) . ' instance</h3>
                    <br><hr><br><br>
                    <form method="POST">

                <h3>Databases</h3>
                <label for="databases>account">Account Database Location: </label><input id="databases>account" type="text" name="databases>account" value="' . $config["databases"]["account"] . '"><br><br>
                <label for="databases>service">Service Database Location: </label><input id="databases>service" type="text" name="databases>service" value="' . $config["databases"]["service"] . '"><br><br>';

                echo '<h3>Authentication</h3>';
                echo '<label for="admin_users">Admin Users: </label><input id="admin_users" type="text" name="admin_users" value="';
                $admin_user_list_readable = "";
                foreach ($config["admin_users"] as $user) { // Iterate through all users in the list of admin users.
                    $admin_user_list_readable = $admin_user_list_readable . $user . ",";
                }
                $admin_user_list_readable = rtrim($admin_user_list_readable, ","); // Trim the last trailing comma.
                echo $admin_user_list_readable; // Display the human readable list of admin users.
                echo '"><br><br>';

                echo '<label for="allow_signups">Allow Signups: </label><input id="allow_signups" type="checkbox" name="allow_signups" ';

                if ($config["allow_signups"] == true) { echo " checked"; }

                echo '><br><br>
                        <input class="button" type="submit" name="submit" id="submit" value="Submit">
                    </form>
                </main>';
            }
            ?>
        </main>
    </body>
</html>
