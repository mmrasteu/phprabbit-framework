<?php
namespace Rabbit\Routes;

use Rabbit\Core\Router;

//Grupo de endpoints abiertos.
Router::group(['name'=>'openEndpoints', 'prefix' => '/api', 'middlewares' => []], function () {
    Router::POST('/auth', ['AuthController', 'getBearerToken']);
});

//Grupo de endpoints para usuarios con rol 'api_user' y con autenticación necesaria.
Router::group(['name'=>'authApiUserEndpoints', 'prefix' => '/api', 'middlewares' => ['RoleMiddleware'=>['api_user']]], function () {
    Router::GET('/status', ['StatusController', 'getStatus']);
});
