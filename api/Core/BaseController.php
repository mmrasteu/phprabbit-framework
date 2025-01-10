<?php 

namespace Rabbit\Core;

use Rabbit\Http\Request;
use Rabbit\Http\Response;
use Rabbit\Core\RequestValidator;

abstract class BaseController {

  protected $request;
  protected $response;

  // Constructor para inyectar las dependencias comunes
  public function __construct(Request $request, Response $response)
  {
      $this->request = $request;
      $this->response = $response;
  }

  protected function validate(RequestValidator $validator) {

    $validatorResponse = $validator->validate();

    if ($validatorResponse !== true ){

        return false;
    }

    return true;
  }

}