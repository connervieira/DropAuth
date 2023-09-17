<?php
include "./config.php";
include "./utils.php";


function dropauth_service_data_fetch($service_id, $data) {
    $service_database = load_database("service"); // Load the services database from disk.

    // TODO: Check to see if the service exists.
    return $service_database[$service_id]]["data"]["main"]["active"];
}

function dropauth_service_data_update($service_id, $data) {
    $service_database = load_database("service"); // Load the services database from disk.

    // TODO: Check to see if the service exists.
    $service_database[$service_id]]["data"]["main"]["active"] = $data; // Save the supplied data to the specified service's active database.

    save_database("service", $service_database); // Save the modified service database to disk.
}
