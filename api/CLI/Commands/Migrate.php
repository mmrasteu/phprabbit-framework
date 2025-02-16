<?php

namespace Rabbit\CLI\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Rabbit\CLI\Commands\Command;
use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\DatabaseException;

class Migrate extends Command {

    // Ruta donde se encuentran las migraciones
    protected $migrationPath = 'migrations/';

    // Tabla de migraciones ya ejecutadas
    protected $migrationTable = 'migrations';

    public function handleMigrateCommand($migrationName = false) {
        // Crear la tabla de migraciones si no existe
        $this->createMigrationsTable();

        if ($migrationName) {
            // Si se pasa el nombre de la migración, ejecutamos esa migración
            $this->runMigration($migrationName);
        } else {
            // Si no se pasa el nombre de migración, ejecutamos todas las migraciones pendientes
            $this->runPendingMigrations();
        }
    }

    // Crear la tabla de migraciones si no existe
    protected function createMigrationsTable() {
        if (!Capsule::schema()->hasTable($this->migrationTable)) {
            Capsule::schema()->create($this->migrationTable, function($table) {
                $table->string('migration');
                $table->timestamps();
            });
            echo "Tabla '$this->migrationTable' creada.\n";
        }
    }

    // Ejecutar una migración específica
    protected function runMigration($migrationName) {
        // Verificar si la migración ya ha sido ejecutada
        if ($this->migrationExecuted($migrationName)) {
            echo "La migración '$migrationName' ya ha sido ejecutada.\n";
            return;
        }

        // Incluir la clase de la migración
        $migrationFile = $this->migrationPath . $migrationName . '.php';

        if (file_exists($migrationFile)) {
            include_once $migrationFile;
            $migrationClassName = preg_replace('/^\d+_\d+_\d+_\d+_/', '', $migrationName);
            try {
                $migration = new $migrationClassName;
                $migration->up();
            } catch(Exception $e) {
                throw new DatabaseException($e);
            }
            

            // Registrar la migración como ejecutada
            $this->markMigrationAsExecuted($migrationName);
            echo "Migración '$migrationName' ejecutada.\n";
        } else {
            echo "La migración '$migrationName' no existe.\n";
        }
    }

    // Ejecutar todas las migraciones pendientes
    protected function runPendingMigrations() {
        $migrationFiles = glob($this->migrationPath . '*.php');

        foreach ($migrationFiles as $migrationFile) {
            $migrationName = basename($migrationFile, '.php');

            // Verificar si la migración ya ha sido ejecutada
            if (!$this->migrationExecuted($migrationName)) {
                $this->runMigration($migrationName);
            }
        }
    }

    // Verificar si una migración ya ha sido ejecutada
    protected function migrationExecuted($migrationName) {
        $exists = Capsule::table($this->migrationTable)
            ->where('migration', $migrationName)
            ->exists();
        return $exists;
    }

    // Marcar una migración como ejecutada
    protected function markMigrationAsExecuted($migrationName) {
        $currentTimestamp = date('Y-m-d H:i:s');
        Capsule::table($this->migrationTable)->insert([
            'migration' => $migrationName,
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
        ]);
    }
}
