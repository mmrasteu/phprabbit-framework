# Changelog
## [1.0.0] - Release date pending
### Will add
- **Code**:
  - Refactoring and final optimization of all code.
  - Code cleanup.
  - Add necessary comments and remove unnecessary comments.
- **Composer**: Implement framework installation via Composer.
- **Documentation**: Publish the final documentation of the framework.

## [0.4.0] - 2025-08-30
### Will add
- **Documentation**: Generate API documentation with Swagger.
- **Status viewer**: Implement a command that shows which controllers are linked to endpoints.

## [0.3.0] - 2025-06-29
### Will add
- **Cache:** Implementation of cached responses.
- **Rate limit:** Implementation of logic to apply custom rate limits to endpoints/controllers.
- **Testing**: Implement testing with PHPUnit and create some example tests.
- **Exception handling:** Full implementation of custom exception handling.
- **`php rabbit` commands:** More basic commands using `php rabbit [command]`.
- **Translations:** Translation of framework messages into English and Spanish. Creation of a custom translation system to avoid extra installations to use the function `__t('message');`.

## [0.2.0] - 2025-02-16
### Added
- **JWT Authentication:** Full implementation of authentication using JWT.
- **ORM:** Basic support for using models and databases with the framework.
- **`php rabbit` commands:** More basic commands using `php rabbit [command]`.
- **Exception handling:** Partial implementation of custom exception handling.
- **Roles:** Full implementation of API user roles.
- **Translations:** Implementation of translation logic with `_t('message');`.
- **Log:** Implementation of the framework log.
- **Swagger:** Implementation of Swagger to generate API documentation.

## [0.1.0] - 2025-01-10
### Added
- **Basic framework structure:** Initial configuration of folders and files.
- **Basic middleware:** A middleware for token validation.
- **Routing management:** Support for basic routes with parameters, regular expressions, and groups.
- **Response system:** Basic responses with status codes.
- **JWT Authentication:** Partial implementation of authentication using JWT. Only to verify the operation of `BearerTokenMiddleware` on groups, not a valid authentication implementation.
- **`php rabbit` commands:** Basic commands using `php rabbit [command]`.
- **Validation rules:** Implementation of validation rules.
