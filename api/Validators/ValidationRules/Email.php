<?php 

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class Email implements ValidationRulesInterface {

  protected $response;

  public function __construct(Response $response) {
    $this->response = $response;
  }

  public function validate(mixed $value): bool {
    // Usamos filter_var con FILTER_VALIDATE_EMAIL para comprobar el formato del correo
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
      return true;
    }
    return false;
  }

  public function getMessage(): string{
    return "This value is not a valid email address";
  }
}