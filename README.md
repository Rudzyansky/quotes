## Quotes

The quotes web application that display funny text with mentioned characters by special pattern.

### Roles

| Name          | Permissions             | Description                         |
|---------------|-------------------------|-------------------------------------|
| BANNED        | none                    | confirmed e-mail                    |
| CORRUPT       | read                    | confirmed e-mail                    |
| GUEST         | read                    | unregistered                        |
| NOT_CONFIRMED | read                    | registered and not confirmed e-mail |
| USER          | read, add               | confirmed e-mail                    |
| MODERATOR     | read, add, edit, delete |                                     |
| ADMINISTRATOR | read, add, edit, delete |                                     |

### Implemented features

* User
    * Register
        * Confirmation
    * Recover
* Quotes
    * Add
    * Edit
    * Delete

### Not implemented features

* User
    * Delete account
    * Profile
        * Show my quotes
        * Show mentioned me quotes
    * Administration panel
        * Add user
        * Remove user
        * Change user permissions
        * Moderate quotes requests
    * Groups
    * Aliases (also known as)
* Quotes
    * Quotes queue for moderation
    * Quote sharing
        * Access for edit another user
        * Access for edit group
    * Private quotes
        * For group
        * For users (maybe its new unique group by quote ID)
