<?php

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class Url implements ValidationRulesInterface {

  protected $response;

  public function __construct(Response $response) {
    $this->response = $response;
  }

  public function validate(mixed $value): bool {
    return filter_var($value, FILTER_VALIDATE_URL) !== false;
  }

  public function getMessage(): string {
    return "This value is not a valid URL";
  }
}
