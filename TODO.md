# To Do

This is an informal to-do list for DropAuth. It is not a comprehensive changelog, nor is it an official declaration of upcoming features.

- [ ] Add the ability to store information for services directly in the DropAuth account data file.
    - [X] Add service management.
        - [X] Add the ability to register services with DropAuth.
        - [X] Add the ability to revoke services with DropAuth.
        - [X] Add the ability to view services that are registered with DropAuth.
        - [ ] Add the ability to edit existing services without erasing their information.
    - [ ] Allow service to interact with DropAuth.
        - [X] Add the ability for registered services to save information with DropAuth.
        - [X] Add the ability for registered services to read information they have stored in DropAuth.
        - [ ] Add documentation that describes how to interface with DropAuth from external services.
- [ ] Add configuration system that allows administrators to manage DropAuth.
    - [X] Create a configuration back-end.
        - [X] Add a configuration handling script.
        - [X] Add file based configuration saving.
    - [X] Validate the usernames and passwords are within the configured length requirements.
    - [ ] Add the ability for an administrator to change the URL that users are redirected to when they are required to log in.
- [ ] Add more advanced account management.
    - [X] Allow admins to disable new account creation.
    - [ ] Allow admins to delete accounts.
    - [ ] Allow admins to change the password of accounts.
