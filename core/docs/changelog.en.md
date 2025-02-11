# Changelog
## [1.0.0] - Release date pending
### Will add
- **Code**:
  - Final refactoring and optimization of all code.
  - Code cleanup.
  - Add necessary comments and remove unnecessary ones.
- **Composer**: Implement framework installation via Composer.
- **Documentation**: Publish the final framework documentation.

## [0.4.0] - Release date pending
### Will add
- **Documentation**: Generate API documentation with Swagger.
- **Status viewer**: Implement a command to show which controllers are linked to endpoints.

## [0.3.0] - Release date pending
### Will add
- **Cache:** Implement cached responses.
- **Rate limit:** Implement logic to apply custom rate limiting to endpoints/controllers.
- **Testing**: Implement testing with PHPUnit and create some example tests.
- **Exception handling:** Full implementation of custom exception handling.
- **`php rabbit` commands**: More basic commands using `php rabbit [command]`.
- **Translations:** Translated framework messages into English and Spanish.

## [0.2.0] - 2025-02-16
### Added
- **JWT Authentication:** Full implementation of authentication using JWT.
- **ORM:** Basic support for using models and databases within the framework.
- **`php rabbit` commands**: More basic commands using `php rabbit [command]`.
- **Exception handling:** Partial implementation of custom exception handling.
- **Roles:** Full implementation of API user roles.
- **Translations:** Implementation of translation logic with `_t('message');`
- **Log:** Framework logging implementation.
- **Swagger:** Swagger implementation for generating API documentation.

## [0.1.0] - 2025-01-10
### Added
- **Basic framework structure:** Initial setup of folders and files.
- **Basic middleware:** Middleware for token validation.
- **Route handling:** Support for basic routes with parameters, regular expressions, and groups.
- **Response system:** Basic responses with status code.
- **JWT Authentication:** Partial implementation of authentication using JWT. Only to verify the functionality of `BearerTokenMiddleware` on groups, not a valid authentication implementation.
- **`php rabbit` commands**: Basic commands using `php rabbit [command]`.
- **Validation rules:** Implementation of validation rules.
