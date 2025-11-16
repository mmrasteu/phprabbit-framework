<?php 

namespace Rabbit\Exceptions;

use Exception;

class BaseException extends Exception {
    protected $message;
    protected $code;
    protected $data;

    public function __construct($message = "", $code = 0, $data = null) {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    // Método para obtener información adicional sobre la excepción
    public function getAdditionalData() {
        return $this->data;
    }
}