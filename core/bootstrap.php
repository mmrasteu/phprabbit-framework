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

// Configurar el idioma (puedes cambiar esto dinámicamente según el idioma del usuario)
$locale = env('APP_LOCALE');

// Verifica que el locale se haya establecido correctamente
if (!$locale) {
  // Fallback al español si no se ha configurado el idioma
  $locale = 'es_ES';
}

// Establecer el idioma y la localización
putenv('LC_ALL=' . $locale);  // Establecer el entorno de idioma
setlocale(LC_ALL, $locale);   // Establecer la localización
bindtextdomain('messages', BASE_PATH . '/locale');  // Establecer la ruta a los archivos .mo
textdomain('messages');  // Establecer el dominio de las traducciones

// Definir constantes
try {
  define('ENVIROMENT', env('ENVIROMENT'));
  define('APP_NAME', env('APP_NAME'));
  define('APP_PORT', env('APP_PORT'));
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
} catch(Exception $e) {
  $msg = _t('There are undefined environment variables') . ': ' . $e-getMessage();
  rabbit_debug($msg);
}

require_once BASE_PATH . '/api/Routes/endpoints.php'; // Incluir las rutas