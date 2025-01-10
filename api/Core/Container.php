<?php

namespace Rabbit\Core;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Closure;
use Exception;

class Container
{
    private $services = [];
    private $shared = [];

    // Registrar un servicio (clase o función) en el contenedor
    public function set($name, $resolver, $shared = false)
    {
        $this->services[$name] = [
            'resolver' => $resolver,
            'singleton' => $shared,
        ];

        // Registrar la información del servicio compartido
        $this->shared[$name] = $shared;
    }

    // Obtener un servicio del contenedor
    public function get($name)
    {
        // Comprobamos si el servicio está registrado
        $service = $this->services[$name] ?? null;
        if (!$service) {
            throw new Exception("Servicio '$name' no encontrado.");
        }

        $resolver = $service['resolver'];
        $singleton = $service['singleton'];

        // Si el servicio es compartido, devolver la misma instancia siempre
        if ($singleton) {
            if (!isset($this->services[$name]['instance'])) {
                $this->services[$name]['instance'] = $this->resolve($resolver);
            }
            return $this->services[$name]['instance'];
        }

        // Si no es compartido, crear una nueva instancia cada vez
        return $this->resolve($resolver);
    }

    // Resolver el servicio llamando a su resolver
    private function resolve($resolver)
    {
        // Si el resolver es una función anónima o una closure
        if ($resolver instanceof Closure) {
            return $resolver($this);
        }

        // Si el resolver es una clase, crear una nueva instancia
        if (interface_exists($resolver)) {
            // Si es una interfaz, obtener su implementación registrada
            $resolver = $this->getConcreteClassForInterface($resolver);
        }

        $class = new ReflectionClass($resolver);
        $constructor = $class->getConstructor();

        // Si no hay constructor, simplemente devolver la instancia
        if (!$constructor) {
            return $class->newInstance();
        }

        // Resolver los parámetros del constructor
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if ($dependency) {
                // Si el parámetro es una clase, obtenerla del contenedor
                $dependencies[] = $this->get($dependency->name);
            }
        }

        // Crear la instancia del controlador pasando las dependencias
        return $class->newInstanceArgs($dependencies);
    }

    // Método para obtener la clase concreta para una interfaz
    private function getConcreteClassForInterface($interface)
    {
        foreach ($this->services as $service => $definition) {
            if (in_array($interface, class_implements($definition['resolver']))) {
                return $definition['resolver'];
            }
        }
        throw new Exception("No se encontró una implementación para la interfaz '$interface'.");
    }

    // Registrar todos los controladores automáticamente
    public function autoRegisterControllers($namespacePrefix)
    {
        $controllers = $this->getControllers($namespacePrefix);
        
        foreach ($controllers as $controller) {
            $this->set($controller, $controller, true);
        }
    }

    // Método auxiliar para obtener todas las clases de controladores en un espacio de nombres
    private function getControllers($namespacePrefix)
    {
        // Usamos ReflectionDirectory para obtener clases del directorio de controladores
        $controllerDirectory = __DIR__ . '/../Controllers'; // Ajusta según tu estructura

        // Obtener todos los archivos PHP de ese directorio
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($controllerDirectory));

        $controllers = [];
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $className = $namespacePrefix . '\\' . basename($file, '.php');
                if (class_exists($className)) {
                    $controllers[] = $className;
                }
            }
        }

        return $controllers;
    }

    // Método para registrar todos los middlewares automáticamente
    public function autoRegisterMiddlewares($namespacePrefix)
    {
        $middlewares = $this->getMiddlewares($namespacePrefix);
        
        foreach ($middlewares as $middleware) {
            // Registrar el middleware en el contenedor como una clase
            $this->set($middleware, $middleware, true);  // Registrado como singleton
        }
    }

    // Método auxiliar para obtener todas las clases de middlewares en un espacio de nombres
    private function getMiddlewares($namespacePrefix)
    {
        $middlewareDirectory = __DIR__ . '/../Middlewares'; // Ajusta según tu estructura

        // Obtener todos los archivos PHP de ese directorio
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($middlewareDirectory));

        $middlewares = [];

        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $className = $namespacePrefix . '\\' . basename($file, '.php');
                $middlewares[] = $className;

            }
        }
        
        return $middlewares;
    }


}
