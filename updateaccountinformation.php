<?php
$force_login_redirect = true; // If the user isn't signed in, redirect them to the login page.
include("./authentication.php"); // Load the authentication system.
include("./config.php"); // Load the authentication system.
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($config["branding"]["name"]); ?> - Update Information</title>
        <link href="./stylesheets/styles.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <main>
            <?php
            if ($_POST["submit"] == "Submit") { // Check to see if the information form was submitted.
                // Get the variables from the submitted form.
                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $phone_number = $_POST["phone"];
                $email = $_POST["email"];
                $house_number = $_POST["housenumber"];
                $street = $_POST["street"];
                $city = $_POST["city"];
                $state = $_POST["state"];
                $country = $_POST["country"];
                $zip = $_POST["zip"];

                include("./utils.php"); // Include the script containing various useful utility functions.

                $account_database = load_database("account"); // Load the account database using the function defined in utils.php
                $account_database[$username]["information"]["name"]["first"] = $first_name; // Add the first name entered by the user to their user information.
                $account_database[$username]["information"]["name"]["last"] = $last_name; // Add the last name entered by the user to their user information.
                $account_database[$username]["information"]["phone"] = $phone_number; // Add the phone number entered by the user to their user information.
                $account_database[$username]["information"]["email"] = $email; // Add the phone number entered by the user to their user information.
                $account_database[$username]["information"]["address"]["housenumber"] = $house_number; // Add the house number entered by the user to their user information.
                $account_database[$username]["information"]["address"]["street"] = $street; // Add the street entered by the user to their user information.
                $account_database[$username]["information"]["address"]["city"] = $city; // Add the city entered by the user to their user information.
                $account_database[$username]["information"]["address"]["state"] = $state; // Add the state entered by the user to their user information.
                $account_database[$username]["information"]["address"]["country"] = $country; // Add the country entered by the user to their user information.
                $account_database[$username]["information"]["address"]["zip"] = $zip; // Add the postal code entered by the user to their user information.

                save_database("account", $account_database);
                echo "<p class='success'>Updated account information.</p><br>
                <a class='button' href='./account.php'>Back</a>";
                exit();
            }
            ?>
                                        

            <a class='button' href='./account.php'>Back</a>";
            <div style="text-align:left;"><a class="button" href="./account.php">Back</a></div>
            <main>
                <h1>Update Account Information</h1>
                <h3>Change your <?php echo htmlspecialchars($config["branding"]["name"]); ?> account information.</h3>
                <br><hr><br><br>
                <form method="POST">
                    <label for="first_name">First Name: </label><input id="first_name" placeholder="John" name="first_name" type="text"><br><br>
                    <label for="last_name">Last Name: </label><input id="last_name" placeholder="Doe" name="last_name" type="text"><br><br>

                    <label for="phone">Phone: </label><input id="phone" placeholder="123-456-7890" name="phone" type="phone"><br><br>
                    <label for="email">Email: </label><input id="email" placeholder="user@server.tld" name="email" type="email"><br><br>

                    <label for="house_number">House Number: </label><input id="house_number" placeholder="12345" name="house_number" type="number" step="1"><br><br>
                    <label for="street">Street: </label><input id="street" placeholder="Maple Street" name="street" type="text"><br><br>
                    <label for="city">City: </label><input id="city" placeholder="Columbus" name="city" type="text"><br><br>
                    <label for="state">State: </label><input id="state" placeholder="OH" name="state" type="text"><br><br>
                    <label for="country">Country: </label><input id="country" placeholder="US" name="country" type="text"><br><br>
                    <label for="zip">ZIP: </label><input id="zip" placeholder="12345" name="zip" type="number" step="1"><br><br>
                    <input type="submit">
                </form>
            </main>
        </main>
    </body>
</html>
