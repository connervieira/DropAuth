# Changelog

## Version 1.0

### Initial Release

This update provides the bare-minimum functionality required to provide authenication services.

- Core functionality
    - Account creation
    - Account authentication


## Version 2.0

### Dependability Update

This update makes extensive changes to DropAuth that make it much more dependable, reliable, and secure.

November 8th, 2022

- Improved security
    - There is now a maximum length limit on passwords and usernames.
    - Usernames are now sanitized, and only alphanumeric characters are permitted.
    - Users can now change their DropAuth password from their account page.
- Improved accessibility
    - Form elements now have accessibility labels.
    - Pages now have 'main' tags to improve screen-reader usability.
- Improved page continuity
    - All main pages now have a short tagline explaining what the page is for.
        - Several taglines from older versions were modified to be more professional.
    - All main pages now have a divider below the header and page content.
- Improved reliability
    - Page loading now terminates if a login redirect is triggered to prevent unauthorized access to pages.
    - Login redirects now use an aboslute path to make automatic redirecting more consistent.


## Version 3.0

### Integration Update

January 24th, 2024

- Added an authentication ID to the session so other programs can identify the source of authentication.
- Added a dedicated configuration system.
    - Administrators can configure DropAuth through a web interface.
- Re-designed the authentication database.
    - The authentication database now supports storing more user information in the user's entry in the account database.
    - Various pieces of metadata are stored from both the initial sign-up, as well as the latest sign-in.
- Moved more logic to `utils.php` to reduce the risk of typos causing unexpected behavior.
- Added a storage system to allow external services to store information with DropAuth.
- Admins now have more control over accounts on their instance.
    - Accounts can be viewed, deleted, and modified by administrators.
- Added auto-redirects to send the user back to the page they were originally on after logging in with DropAuth.
- Users who are already logged in are now automatically redirected from the `index.php` page to the `account.php` page.
