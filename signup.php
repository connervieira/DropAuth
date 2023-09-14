<?php
include "./config.php";
include "./utils.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?> - Sign Up</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <?php
            if ($config["allow_signups"] == false) { // Check to see if signups are disabled.
                echo "<div style='text-align:left;'><a class='button' href='./signin.php'>Sign In</a></div>";
                echo "<p class='error'>The administrator has disabled the creation of new accounts.</p>";
                exit();
            }
            // Get the variables from the submitted form.
            $username = $_POST["username"];
            $password1 = $_POST["password1"];
            $password2 = $_POST["password2"];


            $account_database = load_database("account"); // Load the account database using the function defined in utils.php

            session_start(); // Start a PHP session.
            if ($_SESSION['loggedin'] == 1) { // Check to see if the user is already signed in.
                if ($_SESSION['authid'] == "dropauth") { // Check to see if the user is signed in via DropAuth.
                    echo "<p class='error'>You're already signed in to " . htmlspecialchars($config["branding"]["name"]) . " as " . $_SESSION["username"] . "!</p>";
                } else {
                    echo "<p class='error'>It appears that you're already signed in to an account, but not through " . htmlspecialchars($config["branding"]["name"]) . ". It's possible another program's authentication system is conflicting with " . htmlspecialchars($config["branding"]["name"]) . ". Please try signing out of any other accounts on this website before continuing.</p>";
                }

            } else if (variable_exists($username)) { // Check to see if the user has entered a username.
                if (strlen($username) <= $config["limits"]["length"]["username"]["max"] and strlen($username) >= $config["limits"]["length"]["username"]["min"]) { // Check to make sure the user's selected username is within length requirements.
                    if ($username == preg_replace("/[^a-zA-Z0-9]/", '', $username)) { // Sanitize the username input.
                        if (variable_exists($password1)) { // Check to see if the user has enter a password.
                            if (strlen($password1) <= $config["limits"]["length"]["password"]["max"] and strlen($password1) >= $config["limits"]["length"]["password"]["min"]) { // Check to make sure the user's selected password is within length requirements.
                                if (variable_exists($password2)) { // Check to see if the user has filled out the password confirmation.
                                    if ($password1 == $password2) { // Check to see if the password and the password confirmation match.
                                        if (!isset($account_database[$username])) { // Make sure the selected username doesn't already exist in the account database.
                                            $account_database[$username]["password"] = password_hash($password1, PASSWORD_DEFAULT); // Add the username and password to the database.
                                            $account_database[$username]["information"] = array(); // Add a placeholder for personal information.
                                            $account_database[$username]["preferences"] = array(); // Add a placeholder for user preferences.
                                            $account_database[$username]["diagnostic"] = array(); // Add an array for diagnostic information.
                                            $account_database[$username]["diagnostic"]["time"]["signup"] = time();
                                            $account_database[$username]["diagnostic"]["time"]["latest"] = time();
                                            $account_database[$username]["diagnostic"]["ip"]["signup"] = get_client_ip();
                                            $account_database[$username]["diagnostic"]["ip"]["latest"] = get_client_ip();
                                            $account_database[$username]["diagnostic"]["client"]["platform"]["signup"] = get_client_platform();
                                            $account_database[$username]["diagnostic"]["client"]["platform"]["latest"] = get_client_platform();
                                            $account_database[$username]["diagnostic"]["client"]["browser"]["signup"] = get_client_browser();
                                            $account_database[$username]["diagnostic"]["client"]["browser"]["latest"] = get_client_browser();

                                            $account_database[$username]["2fa"] = array(); // Add a placeholder for two factor authentication information.
                                            $account_database[$username]["services"] = array(); // Add a placeholder for services data.
                                            save_database($account, $account_database); // Save the database to disk using the function defined in utils.php.

                                            echo "<p class='success'>You've successfully created a " . htmlspecialchars($config["branding"]["name"]) . " account! Please log in to continue.</p>
                                            <br>
                                            <a class='button' href='./signin.php'>Sign In</a>";
                                        } else {
                                            echo "<p class='error'>There is already an account with your desired username. Please choose a different username. If you are trying to sign in to an existing account, please use the 'Sign In' page.</p>
                                            <br>
                                            <a class='button' href='./signup.php'>Back</a>
                                            <a class='button' href='./signin.php'>Sign In</a>";
                                        }
                                    } else {
                                        echo "<p class='error'>The password confirmation and password don't match. This means you've probably made a typo. Please make sure that your password and password confirmation match.</p>
                                        <br>
                                        <a class='button' href='./signup.php'>Back</a>";
                                    }
                                } else {
                                    echo "<p class='error'>You've entered a username and password, but you didn't fill out the password confirmation box. Please repeat your password in the 'Password Confirmation' field to ensure you've typed it correctly.</p>
                                    <br>
                                    <a class='button' href='./signup.php'>Back</a>";
                                }
                            } else {
                                echo "<p class='error'>The password doesn't meet the length requirements. Your password needs to be between " . $config["limits"]["length"]["password"]["min"] . " and " . $config["limits"]["length"]["password"]["max"] . " characters in length.</p>
                                <br>
                                <a class='button' href='./signup.php'>Back</a>";
                            }
                        } else {
                            echo "<p class='error'>You've entered a username but not a password! Please provide a password you'd like to use to log in to your " . htmlspecialchars($config["branding"]["name"]) . " account.</p>
                            <br>
                            <a class='button' href='./signup.php'>Back</a>";
                        }
                    } else {
                        echo "<p class='error'>You chosen username has disallowed characters. Usernames can only contain letters and numbers.</p>
                        <br>
                        <a class='button' href='./signup.php'>Back</a>";
                    }
                } else {
                    echo "<p class='error'>The username you've entered doesn't meet the length requirements. Your username needs to be between " . $config["limits"]["length"]["username"]["min"] . " and " . $config["limits"]["length"]["username"]["max"] . " characters in length.</p>
                    <br>
                    <a class='button' href='./signup.php'>Back</a>";
                }
            } else {
                echo '
                <div style="text-align:left;"><a class="button" href="./signin.php">Sign In</a></div>
                <main>
                    <h1>Sign Up</h1>
                    <h3>Sign up for a ' . htmlspecialchars($config["branding"]["name"]) . ' account</h3>
                    <br><hr><br><br>
                    <form method="POST">
                        <label for="username">Username: </label><input id="username" placeholder="Username" name="username"><br><br>
                        <label for="password1">Password: </label><input id="password1" placeholder="Password" name="password1" type="password"><br><br>
                        <label for="password2">Password Confirm:</label><input id="password2" placeholder="Password Confirmation" name="password2" type="password"><br><br>
                        <input type="submit">
                    </form>
                </main>';
            }
            ?>
        </main>
    </body>
</html>
