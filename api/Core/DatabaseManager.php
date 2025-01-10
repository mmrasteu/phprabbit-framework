<?php

namespace Rabbit\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseManager
{
    public static function initialize(array $config)
    {
        $capsule = new Capsule();

        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
