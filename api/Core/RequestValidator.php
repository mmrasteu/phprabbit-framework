<?php 

namespace Rabbit\Core;

use Rabbit\Http\Request;
use Rabbit\Http\Response;


class RequestValidator {
  
  protected $request;

  protected $response;

  protected $accepts = [];

  protected $rules = [];
  
  protected $errors = [];

  public function __construct(Request $request, Response $response) {
    $this->request = $request;
    $this->response = $response;
  }


  public function validate() {

    if (!$this->request || !$this->response) throw new Exception("Validate require Request");

    $this->checkAcceptsParams();
    
    $this->validateRules();

    return true;

  }

  private function checkAcceptsParams() {

    $params = $this->request->getParams();

    foreach ($params as $key => $value) {
      
      if (!in_array($key, $this->accepts)) {
          $this->response->withStatus400('Invalid param \''. $key .'\' on request');
      }

    }

    return true;

  }

  private function validateRules() {

      foreach ($this->rules as $evalParam => $value) {

        $passValidate = true;

        $input = $this->request->getParam($evalParam);

        if ($input === null ) $passValidate = false;

        $validateRules = explode('|', $value);
        $validateRules = array_map('trim', $validateRules);

        if (in_array('required', $validateRules)) $passValidate = true;        

        if($passValidate) { 
          foreach($validateRules as $rule) {

            $this->applyRule($rule, $evalParam, $input);
          }
        }

        if(!empty($this->errors)) {
          $this->response->withStatus400('Failed validation rules', $this->errors );
        }

        return true;

      }
  
      return true;

  }

  protected function applyRule($rule, $param, $value) {
    $className = "\\Rabbit\\Validate\\ValidationRules\\" . ucfirst($rule);

    if (!class_exists($className)) {
      $this->response->withStatus400("Validation rule {$rule} does not exist.");
        //throw new Exception("Validation rule {$rule} does not exist.");
    }

    $ruleInstance = new $className($this->response);

    if (!$ruleInstance->validate($value)) {
        $this->errors[$param][] = $ruleInstance->getMessage();
    }
  }


}