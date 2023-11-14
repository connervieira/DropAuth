# Documentation


## Setup

### Installation

To implement DropAuth into your web service, simply follow these steps.

1. Install Apache if you haven't already.
    - `sudo apt install apache2`
2. Install PHP if you haven't already.
    - `sudo apt install php8.1`
3. Make sure the PHP Apache module is enabled.
    - `sudo a2enmod php8.1`
4. Download DropAuth from the V0LT website, or another source.
5. Copy the DropAuth folder to the root of your webserver.
    - Example: `cp dropauth/ /var/www/html/`
6. Ensure the DropAuth folder is writable to PHP.
    - Example: `chmod 777 /var/www/html/dropauth`
7. Include `authentication.php` on all pages where you want users to have to sign in.
    - Example: `<?php $force_login_redirect = true; include("./dropauth/authentication.php"); ?>`

### Authentication

1. Determine whether or not you want users on each page to be redirected to the login page by changing `$force_login_redirect` to `true` or `false`.
    - If a page should only be accessible to signed in users, set `$force_login_redirect` to `true`.
    - If a page is accessible to everyone, but you still want to load account information, set `$force_login_redirect` to `false`.
2. Users who open pages with the `authentication.php` script will be automatically redirected to the Sign In page if `$force_login_redirect` is set to `true`. However, you can manually redirect users to the following pages to allow them to interact with DropAuth.
    - Sign In: dropauth/signin.php
    - Sign Up: dropauth/signup.php
    - Sign Out: dropauth/signout.php

### Integration

DropAuth contains functionality that allows external services to store information in the DropAuth database. The benefit of this is that all information associated with an account will be deleted if the account is deleted from DropAuth. Without this integration, deleting an account from DropAuth will result in left over information being left in the data of other services. Creating a new account with the same username as the deleted account could lead to a user gain access to the former user's information.

It is important to note that DropAuth does not encrypt or otherwise protect information stored in the service database, since two services installed on the same server would be able to directly intercept information from each-other regardless of whether that information is stored in DropAuth or in the external service itself. You should be careful to only install services that you trust.

To integrate an external service with DropAuth, follow these steps.

1. Log into DropAuth as an administrator.
2. Click the "Services" button on the main page.
3. Under the "Register" section, enter a unique service identifier, and a friendly service name.
    - The service identifier uniquely identifies a service, and is not meant to be changed in the future.
    - The friendly service name makes it easier to tell what the registered service is, and can be updated in the future without affecting functionality.
4. Press "Submit" to register the service.
5. In the PHP service you would like to integrate with DropAuth, add the following line to load the DropAuth storage system: `include("../dropauth/storage.php");`
    - Note that both DropAuth and your external service should be placed in directories that share the same parent directory (For example, "/var/www/html/dropauth/" and "var/www/html/myservice/").
6. To update the data saved to DropAuth, use the following syntax: `dropauth_service_data_update($service_id, $data)`, where `$service_id` is the unique service ID defined previously, and `$data` is the data (generally an array) that you want to store in DropAuth.
7. To fetch the data saved to DropAuth, use the following syntax: `dropauth_service_data_fetch($service_id)`, where `$service_id` is the unique service ID defined previously.

Below is a complete usage example that simply adds a randomly generated number under a specific user to the data stored in DropAuth. The service name for this example is `testing_service`. In order to try this example, make sure this service ID is registered in DropAuth.

```php
<?php
$service_id = "testing_service"; // This variable holds the unique service ID as defined in the DropAuth service database.
include("../dropauth/storage.php"); // Load the DropAuth service storage support script.

$user = "testuser"; // This variable holds a random username that will be used in this script for demonstration purposes. In production, this value would be replaced with DropAuth authentication to get the username of the user who is currently signed in.

$service_data = dropauth_service_data_fetch($service_id); // Fetch the current information stored in DropAuth for this service.

echo "<p>The current information is:</p>";
echo "<pre>" . print_r($service_data) . "</pre><br>"; // Print the current service data.

if (isset($service_data[$user]) == false) { // Check to see if the username set previously doesn't exist yet in the service data.
    $service_data[$user] = array(); // Initialize this user's information to an empty array.
}
array_push($service_data[$user], rand()); // Add a random value to the current service data for the username set previously.

echo "<p>The updated information is:</p>";
echo "<pre>" . print_r($service_data) . "</pre><br>"; // Print the updated service data.

echo "<p>The DropAuth data update response is:</p>";
print_r(dropauth_service_data_update($service_id, $service_data)); // Push the updated service data to the DropAuth storage system.
```


## Implementation

### Database

DropAuth uses a serialized PHP array to store account information. Each account entry is titled after it's username, and has a sub-entry named 'password'. The 'password' subfield contains a hashed version of the user's configured password.

This information is intended to be accessed only by the DropAuth system. However, if you really want to manipulate this information externally, and you understand the risks, you can do so using this example PHP code.

```PHP
$database_file = "./accountDatabase.txt"; // This is the file path to the account database.
$database_contents = unserialize(file_get_contents($database_file)); // This loads the account database from the specified file.

foreach (array_keys($database_contents) as $username) { // Iterate through each account in the database.
    echo "<p>" . $username . ": " . $database_contents[$username]["password"] . "</p>"; // Print each username, and it's associated password hash.
}
```
