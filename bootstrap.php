<?php
require_once __DIR__ . '/vendor/autoload.php';  // Cargar Composer autoloader

require_once __DIR__ . '/api/Routes/endpoints.php'; // Incluir las rutas


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Ajusta la ruta si es necesario
$dotenv->load();

// use Rabbit\Core\DatabaseManager;

// Cargar configuración
# $config = require __DIR__ . '/api/Core/DatabaseConfig.php';

// Inicializar Eloquent
# DatabaseManager::initialize($config);

// Definir constantes

define('BASE_PATH', __DIR__);
define('CACHE_DIR',  BASE_PATH . env('CACHE_DIR'));
define('JWT_SECRET_KEY', env('JWT_SECRET_KEY'));
define('TOKEN_EXPIRATION_TIME', env('TOKEN_EXPIRATION_TIME'));
define('DEFAULT_DATETIME_FORMAT', env('DEFAULT_DATETIME_FORMAT'));
