<?php

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class ArrayValidator implements ValidationRulesInterface {

  protected $response;

  public function __construct(Response $response) {
    $this->response = $response;
  }

  public function validate(mixed $value): bool {
    return is_array($value);
  }

  public function getMessage(): string {
    return "This value is not a valid array";
  }
}
