<?php

// Devolver la configuración usando las variables de entorno
return [
    'driver'    => env('DB_DRIVER', 'mysql'),
    'host'      => env('DB_HOST', '127.0.0.1'),
    'port'      => env('DB_PORT', '3306'),
    'database'  => env('DB_DATABASE', 'mi_base_datos'),
    'username'  => env('DB_USERNAME', 'mi_usuario'),
    'password'  => env('DB_PASSWORD', 'mi_contraseña'),
    'charset'   => env('DB_CHARSET', 'utf8'),
    'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
    'prefix'    => env('DB_PREFIX', ''),
];
