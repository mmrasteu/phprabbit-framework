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
    try {
      $scanDir = BASE_PATH . '/api/Controllers';
      // Usa la librería swagger-php para escanear las anotaciones en tus controladores
      $openapi = Generator::scan([$scanDir]);

      // Guarda la documentación en un archivo JSON
      $swaggerFile = BASE_PATH . '/public/swagger.json';
      file_put_contents($swaggerFile, $openapi->toJson());

      rabbit_debug("La documentación Swagger ha sido generada`", true);
    } catch(Exception $e){
      throw new BaseException($e);
    }
  }

}