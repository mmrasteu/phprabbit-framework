<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;
use OpenApi\Annotations as OA;
use OpenApi\Generator;
use Rabbit\Exceptions\BaseException;

class GenerateSwagger extends Command {
  
  public function handleGenerateSwaggerCommand(){
      $this->generateSwaggerDocumentation();
  }

  private function generateSwaggerDocumentation(){
    // Convertir warnings en excepciones
    set_error_handler(function($severity, $message, $file, $line) {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    });

    // Capturar Fatal Errors
    register_shutdown_function(function() {
        $error = error_get_last();
        if ($error && ($error['type'] === E_ERROR || $error['type'] === E_PARSE)) {
            rabbit_debug("Fatal Error generando Swagger: " . $error['message']);
        }
    });

    try {
        $scanDir = BASE_PATH . '/api/Controllers';
        $openapi = Generator::scan([$scanDir]);

        // Verificar si Swagger encontró errores
        if (empty($openapi->paths)) {
            throw new BaseException("Swagger-php no encontró endpoints o hubo un error en las anotaciones.");
        }

        $swaggerFile = BASE_PATH . '/public/swagger.json';
        file_put_contents($swaggerFile, $openapi->toJson());

        rabbit_debug("La documentación Swagger ha sido generada", true);
    } catch(Exception $e){
        rabbit_debug("Error generando Swagger: " . $e->getMessage());
        throw new BaseException($e);
    } finally {
        // Restaurar el manejador de errores original
        restore_error_handler();
    }
  }

}