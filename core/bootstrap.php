<?php
use Rabbit\Core\DatabaseManager;

define('BASE_PATH', realpath(__DIR__ . '/..'));

require_once BASE_PATH . '/vendor/autoload.php';  // Cargar Composer autoloader

require_once BASE_PATH . '/core/rabbit_functions.php'; // Incluir funciones globales

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH); // Ajusta la ruta si es necesario
$dotenv->load();

// Cargar configuración
$databaseConfig = require BASE_PATH . '/api/Core/DatabaseConfig.php';
// Inicializar Eloquent
DatabaseManager::init($databaseConfig);


// Definir constantes
try {
  define('ENVIROMENT', env('ENVIROMENT'));
  define('APP_NAME', env('APP_NAME'));
  define('APP_PORT', env('APP_PORT'));
  define('APP_LOCALE', env('APP_LOCALE'));
  define('CACHE_DIR',  BASE_PATH . env('CACHE_DIR'));
  define('JWT_SECRET_KEY', env('JWT_SECRET_KEY'));
  define('TOKEN_EXPIRATION_TIME', env('TOKEN_EXPIRATION_TIME'));
  define('DEFAULT_DATETIME_FORMAT', env('DEFAULT_DATETIME_FORMAT'));
  define('TAB_SPACE', env('TAB_SPACE'));
  define('ADMIN_USERNAME', env('ADMIN_USERNAME'));
  define('ADMIN_EMAIL', env('ADMIN_EMAIL'));
  define('ADMIN_PASSWORD', env('ADMIN_PASSWORD'));
  define('RABBIT_LOG_DIRECTORY', BASE_PATH . env('RABBIT_LOG_DIRECTORY'));
  define('RABBIT_LOG_FILENAME', env('RABBIT_LOG_FILENAME'));
  define('CACHE_DIRECTORY', env('CACHE_DIRECTORY'));
  define('DOCS_ROUTE', env('DOCS_ROUTE'));
  define('I18N_DEV_MODE', env('I18N_DEV_MODE'));
} catch(Exception $e) {
  $msg = _t("generic.error.env_vars") . ': ' . $e->getMessage();
  rabbit_debug($msg);
}

require_once BASE_PATH . '/api/Routes/endpoints.php'; // Incluir las rutas