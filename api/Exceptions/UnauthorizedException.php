<?php 

namespace Rabbit\Exceptions;

use Rabbit\Exceptions\BaseException;

class UnauthorizedException extends BaseException {
  protected $message = 'Unauthorized';
  protected $code = 401;

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