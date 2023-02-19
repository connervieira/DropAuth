# Documentation

To implement DropAuth into your web service, simply follow these steps.

1. Download DropAuth from the V0LT website, or another source.
2. Copy the DropAuth folder to the root of your webserver.
    - Example: `cp dropauth/ /var/www/html/`
3. Ensure the DropAuth folder is writable to PHP.
    - Example: `chmod 777 /var/www/html/dropauth`
4. Include `authentication.php` on all pages where you want users to have to sign in.
    - Example: `<?php $force_login_redirect = true; include("./dropauth/authentication.php"); ?>`
5. Determine whether or not you want users on each page to be redirected to the login page by changing `$force_login_redirect` to `true` or `false`.
    - If a page should only be accessible to signed in users, set `$force_login_redirect` to `true`.
    - If a page is accessible to everyone, but you still want to load account information, set `$force_login_redirect` to `false`.
6. Users who open pages with the `authentication.php` script will be automatically redirected to the Sign In page if `$force_login_redirect` is set to `true`. However, you can manually redirect users to the following pages to allow them to interact with DropAuth.
    - Sign In: dropauth/signin.php
    - Sign Up: dropauth/signup.php
    - Sign Out: dropauth/signout.php
