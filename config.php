<?php
$config_database_name = "./dropauth_config.txt"; // This specifies where the configuration file will be stored.

if (file_exists("../dropauth_config.txt")) {
    $config_database_name = "../dropauth_config.txt";
}

if (is_writable(".") == false) {
    echo "<p class=\"error\">The " . getcwd() . " directory is not writable to PHP.</p>";
    exit();
}

// Load and initialize the database.
if (file_exists($config_database_name) == false) { // Check to see if the database file doesn't exist.
    $configuration_database_file = fopen($config_database_name, "w") or die("Unable to create configuration database file."); // Create the file.

    $config = array();
    $config["branding"]["name"] = "DropAuth";
    $config["branding"]["tagline"] = "The simple, secure, drag-and-drop authentication system";
    $config["limits"]["length"]["username"]["max"] = 30;
    $config["limits"]["length"]["username"]["min"] = 4;
    $config["limits"]["length"]["password"]["max"] = 500;
    $config["limits"]["length"]["password"]["min"] = 8;
    $config["allow_signups"] = true;
    $config["admin_users"] = array("admin");
    $config["database_location"] = "./dropauth_account_database.txt";

    fwrite($configuration_database_file, serialize($config)); // Set the contents of the database file to the placeholder configuration.
    fclose($configuration_database_file); // Close the database file.
}

if (file_exists($config_database_name) == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $config = unserialize(file_get_contents($config_database_name)); // Load the database from the disk.
} else {
    echo "<p class=\"error\">The configuration database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}


?>
