<?php
namespace Rabbit\Routes;

use Rabbit\Core\Router;

Router::group(['prefix' => '/api', 'middlewares' => []], function () {
    Router::POST('/auth', ['AuthController', 'getBearerToken']);
});

Router::group(['prefix' => '/api', 'middlewares' => ['BearerTokenMiddleware']], function () {
    Router::GET('/status', ['StatusController', 'getStatus']);
});

Router::group(['prefix' => '/api', 'middlewares' => ['BearerTokenMiddleware', 'TestMiddleware']], function () {
    Router::GET('/status/{id}/otracosa/{test}', ['StatusController', 'getStatusWithID']); 
});

/*
Router::group(['prefix' => '/admin', 'middlewares' => ['AdminMiddleware']], function () {
    Router::POST('/create', ['AdminController', 'createItem']);
    Router::DELETE('/delete/{id}', ['AdminController', 'deleteItem']);
});*/


/*
Router::GET('users/{id}', 'UserController@getUser');
Router::GET('users', 'UserController@getUsers');
Router::POST('users', 'UserController@createUser');
Router::PUT('users/{id}', 'UserController@updateUser');
Router::DELETE('users/{id}', 'UserController@deleteUser');
*/

