<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>DropAuth - Change Password</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <?php

            // Get the variables from the submitted form.
            $oldpassword = $_POST["oldpassword"];
            $password1 = $_POST["password1"];
            $password2 = $_POST["password2"];

            include("./utils.php"); // Include the script containing various useful utility functions.

            $account_database = load_database("./accountDatabase.txt"); // Load the account database using the function defined in utils.php

            if (variable_exists($oldpassword)) { // Check to see if the user has entered their current password before attempting to change the password.
                if (password_verify($oldpassword, $account_database[$username]["password"])) { // Verify that the password entered by the user matches the password on file in the account database.
                    if (variable_exists($password1)) { // Check to see if the user has enter a password.
                        if (strlen($password1) <= 500) { // Check to make sure the user's password is under 500 characters.
                            if (variable_exists($password2)) { // Check to see if the user has filled out the password confirmation.
                                if ($password1 == $password2) { // Check to see if the password and the password confirmation match.
                                    if (isset($account_database[$username])) { // Make sure the selected username doesn't already exist in the account database.
                                        $account_database[$username]["password"] = password_hash($password1, PASSWORD_DEFAULT); // Change the user's password.
                                        file_put_contents('./accountDatabase.txt', serialize($account_database)); // Save the database to the disk.
                                        echo "<p class='success'>Your password has been successfully changed.</p><br>
                                        <a class='button' href='./account.php'>Back</a>";
                                    } else {
                                        echo "<p class='error'>There is no account in the database with your username. This condition should never happen, and it's likely DropAuth was configured improperly. Please contact and administrator and make them aware of the issue.</p><br>
                                        <a class='button' href='./account.php'>Back</a>";
                                    }
                                } else {
                                    echo "<p class='error'>The new password and new password confirmation don't match. This means you've probably made a typo. Please make sure that your password and password confirmation match.</p><br>
                                    <a class='button' href='./changepassword.php'>Back</a>";
                                }
                            } else {
                                echo "<p class='error'>You've entered a new password, but you didn't fill out the password confirmation box. Please repeat your password in the 'Password Confirmation' field to ensure you've typed it correctly.</p><br>
                                <a class='button' href='./changepassword.php'>Back</a>";
                            }
                        } else {
                            echo "<p class='error'>The password you've entered is too long. Please ensure your password is 500 characters or less.</p><br>
                            <a class='button' href='./changepassword.php'>Back</a>";
                        }
                    } else {
                        echo "<p class='error'>You've entered your current password, you didn't enter a new password.</p><br>
                        <a class='button' href='./changepassword.php'>Back</a>";
                    }
                } else {
                    echo "<p class='error'>The current password you've entered is incorrect. Please enter the current password associated with your account.</p><br>
                    <a class='button' href='./changepassword.php'>Back</a>";
                }
            } else {
                echo '
                <div style="text-align:left;"><a class="button" href="./account.php">Back</a></div>
                <main>
                    <h1>Change Password</h1>
                    <h3>Change your DropAuth password</h3>
                    <br><hr><br><br>
                    <form method="POST">
                        <label for="oldpassword">Current Password: </label><input id="oldpassword" placeholder="Current Password" name="oldpassword" type="password"><br><br>
                        <label for="password1">New Password: </label><input id="password1" placeholder="Password" name="password1" type="password"><br><br>
                        <label for="password2">Confirm Password:</label><input id="password2" placeholder="Password Confirmation" name="password2" type="password"><br><br>
                        <input type="submit">
                    </form>
                </main>';
            }
            ?>
        </main>
    </body>
</html>
