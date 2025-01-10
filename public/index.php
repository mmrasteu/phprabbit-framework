<?php
require_once __DIR__ . '/../bootstrap.php';

use Rabbit\Core\Container;
use Rabbit\Core\Router;
use Rabbit\Http\Request;
use Rabbit\Http\Response;

$config = require_once __DIR__ . '/../config/app.php';

// Crear el contenedor
$container = new Container();

// Registrar controladores y middlewares
$container->autoRegisterControllers($config['controller_namespace']);
$container->autoRegisterMiddlewares($config['middleware_namespace']);

// Registrar servicios principales
$container->set('Rabbit\Interfaces\RequestInterface', 'Rabbit\Http\Request', true);
$container->set('Rabbit\Interfaces\ResponseInterface', 'Rabbit\Http\Response', true);
$container->set('Rabbit\Http\Request', 'Rabbit\Http\Request', true);
$container->set('Rabbit\Http\Response', 'Rabbit\Http\Response', true);

// Obtener las instancias
$request = $container->get('Rabbit\Http\Request');
//$response = $container->get('Rabbit\Http\Response');

// Configurar Router y despachar
Router::setControllerNamespace($config['controller_namespace']);
Router::setMiddlewareNamespace($config['middleware_namespace']);
Router::dispatch($request, $container);
