<?php

// Devolver la configuración usando las variables de entorno
return [
    'driver'    => env('DB_DRIVER', 'mysql'),
    'host'      => env('DB_HOST', '127.0.0.1'),
    'port'      => env('DB_PORT', '3306'),
    'database'  => env('DB_DATABASE', 'rabbit_db'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', 'root'),
    'charset'   => env('DB_CHARSET', 'utf8'),
    'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
    'prefix'    => env('DB_PREFIX', ''),
];
