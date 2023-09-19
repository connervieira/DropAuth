<?php
include (dirname(__FILE__) . "/config.php");

global $config;

function variable_exists($variable_to_check) {
    if ($variable_to_check !== null and $variable_to_check !== "") {
        return true;
    } else {
        return false;
    }  
}

function load_database($database_name) {
    global $config;
    $database_to_load = $config["databases"][$database_name];

    if (file_exists($database_to_load)) { // Check if the selected database already exists
        return unserialize(file_get_contents($database_to_load)); // Load the selected database file from the disk.
    } else {
        if (is_writable(".")) { // Check if the current directory is writable by PHP before trying to create the database file.
            file_put_contents($database_to_load, serialize(array())); // Create a database file with an empty array and write it to the disk.
            return array(); // Load an empty array.
        } else {
            echo "<p class='error'>The DropAuth folder is not writable by PHP. This is a technical error. Please contact a site admin to make them aware of this issue.</p>"; // Throw an error if the DropAuth directory isn't writable by PHP.
            exit();
        }
    }
}

function save_database($database_name, $save_data) {
    global $config;
    $save_path = $config["databases"][$database_name];
    file_put_contents($save_path, serialize($save_data)); // Save the database to the disk.
}



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

?>
