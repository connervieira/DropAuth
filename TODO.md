# To Do

This is an informal to-do list for DropAuth. It is not a comprehensive changelog, nor is it an official declaration of upcoming features.

- [X] Add the ability to store information for services directly in the DropAuth account data file.
    - [X] Add service management.
        - [X] Add the ability to register services with DropAuth.
        - [X] Add the ability to revoke services with DropAuth.
        - [X] Add the ability to view services that are registered with DropAuth.
        - [X] Add the ability to edit existing services without erasing their information.
    - [X] Allow service to interact with DropAuth.
        - [X] Add the ability for registered services to save information with DropAuth.
        - [X] Add the ability for registered services to read information they have stored in DropAuth.
        - [X] Add documentation that describes how to interface with DropAuth from external services.
- [X] Add configuration system that allows administrators to manage DropAuth.
    - [X] Create a configuration back-end.
        - [X] Add a configuration handling script.
        - [X] Add file based configuration saving.
    - [X] Validate the usernames and passwords are within the configured length requirements.
- [X] Add more advanced account management.
    - [X] Allow admins to disable new account creation.
    - [X] Allow admins to list all accounts.
    - [X] Allow admins to delete accounts.
- [X] Update the 'last seen' time when a user logs in.
- [ ] Allow administrators to update a user's password manually.
