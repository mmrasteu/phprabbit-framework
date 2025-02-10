<?php
// Rabbit\Core\DatabaseManager.php
namespace Rabbit\Core;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Facade;

class DatabaseManager
{
    public static function init(array $config)
    {
        $capsule = new Capsule();

        // Configurar la conexión con los parámetros correctos
        $capsule->addConnection($config);

        // Configurar Capsule como global
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Configurar el contenedor de la aplicación para las facades
        Facade::setFacadeApplication($capsule);
    }
}
