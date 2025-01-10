<?php 

namespace Rabbit\Validators;

use Rabbit\Core\RequestValidator;

class StatusValidator extends RequestValidator {

  protected $accepts = [
    'id',
  ];

  protected $rules = [
    'id' => 'required | numeric'
  ];
}