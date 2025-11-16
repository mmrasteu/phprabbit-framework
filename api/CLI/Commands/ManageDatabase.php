<?php

namespace Rabbit\CLI\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Rabbit\CLI\Commands\Command;
use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\DatabaseException;

class ManageDatabase extends Command {

    // Ruta donde se encuentran las migraciones
    protected $migrationPath = 'migrations/';

    // Tabla de migraciones ya ejecutadas
    protected $migrationTable = 'migrations';
}
