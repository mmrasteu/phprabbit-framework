<?php 

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class Numeric implements ValidationRulesInterface {

  protected $response;

  public function __construct(Response $response) {
    $this->response = $response;
  }

  public function validate(mixed $value): bool {
    if (is_numeric($value)) {
      return true;
    } else {
      return false;
    }
  }

  public function getMessage(): string{
    return "This value is not numeric";
  }

}