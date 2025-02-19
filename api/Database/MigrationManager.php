<?php

namespace Rabbit\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class MigrationManager
{
    protected $migrationsPath = __DIR__ . '/../../migrations/';

    // Ejecutar todas las migraciones
    public function run()
    {
        $migrations = $this->getMigrations();

        foreach ($migrations as $migration) {
            $class = $this->getClassName($migration);
            require_once $this->migrationsPath . $migration;
            $migrationInstance = new $class();
            $migrationInstance->up();
            echo "Migración ejecutada: $class\n";
        }
    }

    // Obtener todos los archivos de migración
    public function getMigrations()
    {
        $files = scandir($this->migrationsPath);
        return array_filter($files, fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'php');
    }

    // Obtener el nombre de la clase a partir del archivo de migración
    public function getClassName($file)
    {
        $name = pathinfo($file, PATHINFO_FILENAME);
        return str_replace('_', '', ucwords($name, '_'));
    }

    // Configuración de la base de datos
    public function configureDatabase()
    {
        $config = require __DIR__ . '/../../src/Config/database.php';

        // Configurar Eloquent
        $capsule = new Capsule;
        $capsule->addConnection($config);

        // Hacer disponible Eloquent a través de todo el framework
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
