<?php
namespace Rabbit\Routes;

//Controllers
use Rabbit\Controllers\StatusController;

use Rabbit\Core\Router;

// Definir las rutas
Router::GET('/', function(){echo "Pagina de Inicio";});
Router::GET('/status/{id}', [new StatusController, 'getStatus']);

/*
Router::GET('users/{id}', 'UserController@getUser');
Router::GET('users', 'UserController@getUsers');
Router::POST('users', 'UserController@createUser');
Router::PUT('users/{id}', 'UserController@updateUser');
Router::DELETE('users/{id}', 'UserController@deleteUser');
*/

