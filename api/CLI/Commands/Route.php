<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;
use Rabbit\Core\Router;

class Route extends Command { 
  // Función para mostrar las rutas registradas.
  public function handleRouteCommand($arrayOptions)
  {
      // Recorremos las rutas registradas por método (GET, POST, etc.)
      $routes = $this->getRoutes();
      
      $group = (in_array('--group', $arrayOptions)) ? true : false;
      $middlewares = (in_array('--middleware', $arrayOptions)) ? true : false;
      
      if ($group) {
          $this->displayRoutesByGroup($routes, $middlewares);
      } else {
          $this->displayAllRoutes($routes, $middlewares);
      }
  }

  // Obtener las rutas registradas por el Router.
  private function getRoutes()
  {
      $allRoutes = [];

      foreach (Router::$routes as $method => $routes) {
          foreach ($routes as $uri => $route) {
              
              $allRoutes[] = [
                  'method' => $method,
                  'uri' => $uri,
                  'action' => $route['action'],
                  'groupName' => $route['groupName'],
                  'middlewares' => $route['middlewares'] ?? [],
              ];
          }
      }
      return $allRoutes;
  }

  // Mostrar todas las rutas sin agrupar ni mostrar middlewares
  private function displayAllRoutes($routes, $middlewares)
  {
      echo "Rutas registradas:\n";
      foreach ($routes as $route) {
          echo "    [" . $route['method'] . "] " . $route['uri'] . " ". $route['action'][0] . ":" . $route['action'][1] . "\n";

          if($middlewares) {
            $aMiddlewares = [];
            foreach($route['middlewares'] as $key => $value) {
              $aMiddlewares[] = (!is_numeric($key)) ? $key: $value;
            }
            echo "        Middlewares: " . implode(', ', $aMiddlewares) . "\n";
          }
      }
  }

  // Mostrar las rutas ordenadas por el grupo de prefix
  private function displayRoutesByGroup($routes, $middlewares)
  {
      echo "Rutas agrupadas por grupo:\n";
      $groupedRoutes = [];

      // Agrupar las rutas por 'group' (prefix)
      foreach ($routes as $route) {
          $groupedRoutes[$route['groupName']][] = $route;
      }

      // Mostrar las rutas agrupadas por grupo (prefix)
      foreach ($groupedRoutes as $group => $groupRoutes) {
          echo "Grupo: '" . $group . "'\n";
          foreach ($groupRoutes as $route) {
            echo "    [" . $route['method'] . "] " . $route['uri'] . " ". $route['action'][0] . ":" . $route['action'][1] . "\n";
            
            if($middlewares) {
              $aMiddlewares = [];
              foreach($route['middlewares'] as $key => $value) {
                $aMiddlewares[] = (!is_numeric($key)) ? $key: $value;
              }
              echo "        Middlewares: " . implode(', ', $aMiddlewares) . "\n";
            }
          }
      }
  }

}