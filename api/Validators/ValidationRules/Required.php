<?php 

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class Required implements ValidationRulesInterface {

  protected $response;

  public function __construct(Response $response) {
    $this->response = $response;
  }
  
  public function validate(mixed $value=null): bool {
    if (!is_null($value)) {
      return true;
    }
    return false;
  }

  public function getMessage(): string{
    return "This value is required";
  }

}