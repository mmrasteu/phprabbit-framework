<?php 

namespace Rabbit\Exceptions;

use Rabbit\Exceptions\BaseException;

class DatabaseException extends BaseException {
  protected $message = 'Database failed';
  protected $code = 500;

  public function __construct($message = null, $code = null, $data = null) {
      if ($message) {
          $this->message = $message;
      }
      if ($code) {
          $this->code = $code;
      }
      parent::__construct($this->message, $this->code, $data);
  }
}