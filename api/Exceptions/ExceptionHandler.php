<?php 

namespace Rabbit\Exceptions;

use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\DatabaseException;
use Rabbit\Exceptions\ValidationException;

class ExceptionHandler {
  public static function handle(\Throwable $e) {
      // Aquí puedes hacer un manejo de excepciones global
      if ($e instanceof DatabaseException) {
          // Maneja la excepción de la base de datos
          rabbit_debug("Database Error: " . $e->getMessage());
          // Puedes loguear el error o enviar un mensaje específico
      } elseif ($e instanceof ValidationException) {
          // Maneja la excepción de validación
          $extraData = $e->getAdditionalData();
          if ($extraData) {
            $extraData = json_encode($extraData['message']);
          } else {
            $extraData = '';
          }
          rabbit_debug("Validation Error: " . $e->getMessage());
          rabbit_debug("Validation Error Extra Data: " . $extraData);
      } elseif ($e instanceof UnauthorizedException) {
        // Maneja la excepción de validación
        $extraData = $e->getAdditionalData();
        if ($extraData) {
          $extraData = json_encode($extraData['message']);
        } else {
          $extraData = '';
        }
        rabbit_debug("Unauthorized Error: " . $e->getMessage());
        rabbit_debug("Unauthorized Error Extra Data: " . $extraData);
      } elseif ($e instanceof BaseException) {
          // Maneja cualquier otro tipo de excepción base
          rabbit_debug("Error: " . $e->getMessage());
      } else {
          // Maneja excepciones generales
          rabbit_debug("General Error: " . $e->getMessage());
      }
  }
}