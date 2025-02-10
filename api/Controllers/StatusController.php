<?php

namespace Rabbit\Controllers;

use Rabbit\Core\BaseController;
use Rabbit\Validators\StatusValidator;
use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\ValidationException;
use Rabbit\Exceptions\DatabaseException;
use Rabbit\Exceptions\ExceptionHandler;
use OpenApi\Annotations as OA;  // Importar las anotaciones de Swagger

class StatusController extends BaseController {

  /**
   * @OA\Get(
   *   path="/api/status",
   *   summary="Endpoint de estado del servidor,
   *   tags={"Status"},
   *   security={{"BearerAuth":{}}}, 
   *   @OA\Response(response=200, description="OK"),
   *   @OA\Response(response=403, description="Acceso denegado")
   * )
   */
  public function getStatus() {
    try {
      // Validación de la solicitud
      $this->validate(new StatusValidator($this->request, $this->response));
      
      // Datos de respuesta
      $data = [
        'server_status' => 'OK'
      ];

      $this->response->withStatus200($data);
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
}
