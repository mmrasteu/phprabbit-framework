<?php
require_once __DIR__ . '/../core/bootstrap.php';

use Rabbit\Core\Container;
use Rabbit\Core\Router;
use Rabbit\Core\WebView;
use Rabbit\Http\Request;
use Rabbit\Http\Response;

$config = require_once BASE_PATH . '/core/config/app.php';

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

// Crear una instancia de WebView y manejar la solicitud
$webView = new WebView();
$webView->handleRequest($request);

// Configurar Router y despachar
Router::setControllerNamespace($config['controller_namespace']);
Router::setMiddlewareNamespace($config['middleware_namespace']);
Router::dispatch($request, $container);
