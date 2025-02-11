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
   *   summary="Endpoint de estado del servidor",
   *   tags={"API Endpoints"},
   *   security={{"BearerAuth":{}}}, 
       *   @OA\Response(
     *     response=200,
     *     description="Inicio de sesión exitoso",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=200),
     *       @OA\Property(property="title", type="string", example="Success"),
     *       @OA\Property(property="message", type="string", example="200 - Success"),
     *       @OA\Property(property="data", type="object",
     *         @OA\Property(property="serverStatus", type="string", example="OK"),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Credenciales inválidas",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=401),
     *       @OA\Property(property="title", type="string", example="Unauthorized"),
     *       @OA\Property(property="message", type="string", example="401 - Unauthorized"),
     *       @OA\Property(property="errors", type="object",
     *         @OA\Property(property="message", type="string", example=""),
     *         @OA\Property(property="details", type="array",
     *           @OA\Items(type="string", example="")
     *         )
     *       )
     *     )
     *   )
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
