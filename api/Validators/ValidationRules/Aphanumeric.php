<?php

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class Alphanumeric implements ValidationRulesInterface {

  protected $response;

  public function __construct(Response $response) {
    $this->response = $response;
  }

  public function validate(mixed $value): bool {
    return ctype_alnum($value);
  }

  public function getMessage(): string {
    return "This value should only contain alphanumeric characters";
  }
}
