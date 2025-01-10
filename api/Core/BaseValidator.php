<?php 

namespace Rabbit\Validate;

abstract class BaseValidator {

    protected function applyRule($rule, $value, $params = []) {
        $className = "\\Rabbit\\Validate\\ValidationRules\\" . ucfirst($rule);
    
        if (!class_exists($className)) {
            throw new \Exception("Validation rule {$rule} does not exist.");
        }
    
        $ruleInstance = new $className();
    
        if (!$ruleInstance->validate($value, ...$params)) {
            $this->errors[] = $ruleInstance->getMessage();
        }
    }

}