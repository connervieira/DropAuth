# Changelog

## Version 1.0

### Initial Release

- Core functionality
    - Account creation
    - Account authentication


## Version 2.0

### Dependability Update

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


## Version 2.1

*Release date to be determined*

- Added an authentication ID to the session so other programs can identify the source of authentication.
