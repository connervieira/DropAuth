<?php
include (dirname(__FILE__) . "/config.php");

global $config;





function on_account_delete($user_to_delete) {
    // If you have manually integrated DropAuth with external services, you can use this function to delete information from your associated services.
    // Here you can load external databases, remove information, and update statistics.
    // If this function returns 'true', the account deletion will continue. If this function returns 'false' account deletion will halt.
    return true;
}





// This function is called to delete an account from the DropAuth database.
function delete_account($user_to_delete) {
    $service_database = load_database("service"); // Load the services database from disk.
    $account_database = load_database("account"); // Load the account database from disk.

    // Remove this user from any service databases.
    foreach (array_keys($service_database) as $service_id) { // Iterate through each service in the service database.
        if (isset($service_database[$service_id][$user_to_delete]) == true) { // Check to see if the user being deleted exists in this service.
            unset($service_database[$service_id][$user_to_delete]); // Delete this user from this service.
        }
    }

    // Remove this use from the account database.
    unset($account_database[$user_to_delete]);

    if (on_account_delete($user_to_delete)) {
        if (save_database("service", $service_database)) { // Attempt to save the service database, and only continue if it is successful.
            if (save_database("account", $account_database)) { // Attempt to save the account database, and only continue if it is successful.
                //echo "<p class='success'>Successfully deleted user.</p>";
                return true;
            } else {
                echo "<p class='error'>Failed to delete user. Unable to update account database file.</p>";
                return false;
            }
        } else {
            echo "<p class='error'>Failed to delete user. Unable to update service database file.</p>";
            return false;
        }
    } else {
        echo "<p class='error'>Failed to delete user. Unable to execute 'on_account_delete()' function.</p>";
        return false;
    }
}



// This function simply checks that a variable exists and isn't set to a blank value.
function variable_exists($variable_to_check) {
    if ($variable_to_check !== null and $variable_to_check !== "") {
        return true;
    } else {
        return false;
    }  
}

// This function loads a database from the configuration.
function load_database($database_name) {
    global $config;
    $database_to_load = $config["databases"][$database_name];

    if (file_exists($database_to_load)) { // Check if the selected database already exists
        return unserialize(file_get_contents($database_to_load)); // Load the selected database file from the disk.
    } else {
        if (is_writable(".")) { // Check if the current directory is writable by PHP before trying to create the database file.
            echo "<p class='error'>The requested DropAuth database (" . $database_to_load . ") does not exist.</p>"; // Throw an error if the DropAuth directory isn't writable by PHP.
            return array(); // Load an empty array.
        } else {
            echo "<p class='error'>The DropAuth folder is not writable by PHP. This is a technical error. Please contact a site admin to make them aware of this issue.</p>"; // Throw an error if the DropAuth directory isn't writable by PHP.
            exit();
        }
    }
}

// This function saves information to a database from the configuration.
function save_database($database_name, $save_data) {
    global $config;
    $save_path = $config["databases"][$database_name];
    if (is_writable($save_path)) { // Check to see if the save path is writable.
        file_put_contents($save_path, serialize($save_data)); // Save the database to the disk.
        return true;
    } else {
        echo "<p class='error'>The '" . $database_name . "' database is not writable.</p>";
        return false;
    }
}



// This function attempts to get the client IP through various methods.
function get_client_ip() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWNIP'; // If all else fails, return "UNKNOWNIP" to indicate that the IP wasn't successfully determined.
    }

    return $ipaddress;
}

// This function attempts to get the platform the client is running.
function get_client_platform() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    } else if (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    } else if (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    } else if (preg_match('/android/i', $u_agent)) {
        $platform = 'Android';
    } else if (preg_match('/ios/i', $u_agent)) {
        $platform = 'iOS';
    } else if (preg_match('/bsd/i', $u_agent)) {
        $platform = 'BSD';
    } else {
        $platform = "Unknown";
    }
    return $platform;
}

// This function attempts to get the browser used by the client.
function get_client_browser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
        $browser = "MSIE";
    } else if (preg_match('/Firefox/i', $u_agent)) {
        $browser = "Firefox";
    } else if (preg_match('/Brave/i', $u_agent)) {
        $browser = "Brave";
    } else if (preg_match('/Chrome/i', $u_agent)) {
        $browser = "Chrome";
    } else if (preg_match('/Safari/i', $u_agent)) {
        $browser = "Safari";
    } else if (preg_match('/Opera/i', $u_agent)) {
        $browser = "Opera";
    } else if (preg_match('/Netscape/i', $u_agent)) {
        $browser = "Netscape";
    } else {
        $browser = "Unknown";
    }
    return $browser;
}


if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool {
        $needle_len = strlen($needle);
        return ($needle_len === 0 || 0 === substr_compare($haystack, $needle, - $needle_len));
    }
}
?>
