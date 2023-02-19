# Documentation


## Setup

### Installation

To implement DropAuth into your web service, simply follow these steps.

1. Download DropAuth from the V0LT website, or another source.
2. Copy the DropAuth folder to the root of your webserver.
    - Example: `cp dropauth/ /var/www/html/`
3. Ensure the DropAuth folder is writable to PHP.
    - Example: `chmod 777 /var/www/html/dropauth`
4. Include `authentication.php` on all pages where you want users to have to sign in.
    - Example: `<?php $force_login_redirect = true; include("./dropauth/authentication.php"); ?>`

### Integration

1. Determine whether or not you want users on each page to be redirected to the login page by changing `$force_login_redirect` to `true` or `false`.
    - If a page should only be accessible to signed in users, set `$force_login_redirect` to `true`.
    - If a page is accessible to everyone, but you still want to load account information, set `$force_login_redirect` to `false`.
2. Users who open pages with the `authentication.php` script will be automatically redirected to the Sign In page if `$force_login_redirect` is set to `true`. However, you can manually redirect users to the following pages to allow them to interact with DropAuth.
    - Sign In: dropauth/signin.php
    - Sign Up: dropauth/signup.php
    - Sign Out: dropauth/signout.php


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
