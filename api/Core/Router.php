<?php

namespace Rabbit\Core;

use Rabbit\Http\Request;
use Rabbit\Http\Response;
use Rabbit\Core\Container;
use Exception;

class Router
{
    public static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static $reservedRoutes = [DOCS_ROUTE, 'OTRARUTA'];

    public static $groups = [];
    public static $currentGroup = null;

    public static $controllerNamespace = 'Rabbit\Controllers';
    public static $middlewareNamespace = 'Rabbit\Middlewares';

    public static function getControllerNamespace()
    {
        return self::$controllerNamespace;
    }

    public static function setControllerNamespace($namespace)
    {
        self::$controllerNamespace = $namespace;
    }

    public static function getMiddlewareNamespace()
    {
        return self::$middlewareNamespace;
    }

    public static function setMiddlewareNamespace($namespace)
    {
        self::$middlewareNamespace = $namespace;
    }

    // Define un grupo con un prefijo y middlewares
    public static function group($options, $callback)
    {
        $prefix = $options['prefix'] ?? '';
        $name = $options['name'] ?? '';
        $middlewares = $options['middlewares'] ?? [];
        
        $groupId = uniqid('group_', true);

        self::$groups[$groupId] = [
            'name' => $name,
            'prefix' => $prefix,
            'middlewares' => $middlewares
        ];

        // Establece el grupo actual y ejecuta el callback
        self::$currentGroup = $groupId;
        $callback();

        // Restablece el grupo actual
        self::$currentGroup = null;
    }

    public static function GET($pattern, $controllerAction, $middlewares = [])
    {
        self::addRoute('GET', $pattern, $controllerAction, $middlewares);
    }

    public static function POST($pattern, $controllerAction, $middlewares = [])
    {
        self::addRoute('POST', $pattern, $controllerAction, $middlewares);
    }

    public static function PUT($pattern, $controllerAction, $middlewares = [])
    {
        self::addRoute('PUT', $pattern, $controllerAction, $middlewares);
    }

    public static function DELETE($pattern, $controllerAction, $middlewares = [])
    {
        self::addRoute('DELETE', $pattern, $controllerAction, $middlewares);
    }

    private static function addRoute($method, $pattern, $controllerAction, $middlewares = [])
    {
        $group = self::$currentGroup ? self::$groups[self::$currentGroup] : null;

        if ($group) {
            $pattern = rtrim($group['prefix'], '/') . '/' . ltrim($pattern, '/');
            $pattern = rtrim($pattern, '/');
            $middlewares = array_merge($group['middlewares'], $middlewares);
        }

        if(in_array($pattern, self::$reservedRoutes)){

            $msg = "Error in endpoints: `". $pattern . "`" . ' is a reserved route';

            $response = new Response();
            $response->withStatus404($msg); // Mejorar esta función para también enviar el cuerpo de la respuesta

        }

        self::$routes[$method][$pattern] = [
            'action' => $controllerAction,
            'middlewares' => $middlewares,
            'groupName' => $group['name']
        ];
    }

    public static function dispatch(Request $request, Container $container)
    {
        $uri = strtok($request->getUri(), '?');
        $method = $request->getMethod();

        if (isset(self::$routes[$method])) {
            
            foreach (self::$routes[$method] as $pattern => $route) {
                $pattern = preg_replace('/\{(\w+)\}/', '(.*?)', $pattern);
                if (preg_match("#^$pattern$#", $uri, $params)) {
                    array_shift($params);
                    
                    self::handleMiddlewares($route['middlewares'], $request, $container);

                    $action = $route['action'];
                    if (is_array($action)) {
                        list($controllerClass, $method) = $action;
                        $controllerClass = self::$controllerNamespace . '\\' . $controllerClass;
                        $controller = $container->get($controllerClass);

                        call_user_func_array([$controller, $method], $params);
                    } elseif (is_callable($action)) {
                        call_user_func_array($action, $params);
                    }

                    return;
                }

                
            }
        }
        
        $response = new Response();
        $response->withStatus404(); // Mejorar esta función para también enviar el cuerpo de la respuesta
        
    }

    private static function handleMiddlewares(array $middlewares, Request $request, Container $container)
    {
        foreach ($middlewares as $key => $middleware) {
            if(is_array($middleware)) {
                $args = $middleware;
                $middleware = $key;
                $middlewareClass = self::$middlewareNamespace . '\\' . $middleware;
                $middlewareInstance = new $middlewareClass($args);

                $middlewareInstance->handle($request, new Response(), function () { });

            } else {
                $middlewareClass = self::$middlewareNamespace . '\\' . $middleware;
                $middlewareInstance = $container->get($middlewareClass);
                
                $middlewareInstance->handle($request, new Response(), function () { });
            }
        }
    }

}
