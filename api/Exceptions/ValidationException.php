<?php 

namespace Rabbit\Exceptions;

use Rabbit\Exceptions\BaseException;

class ValidationException extends BaseException {
  protected $message = 'Validation failed';
  protected $code = 400;

  public function __construct($message = null, $code = null, $data = null) {
      if ($message) {
          $this->message = $message;
      }
      if ($code) {
          $this->code = $code;
      }
      if ($data) {
        $this->data = $data;
    }
      parent::__construct($this->message, $this->code, $data);
  }
}