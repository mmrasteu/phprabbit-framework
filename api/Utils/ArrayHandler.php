<?php 

namespace Rabbit\Utils;

class ArrayHandler {
  
  public function __construct(){

  }

  public static function flattenArray(array $array): array {
    $result = [];
    foreach ($array as $item) {
        if (is_array($item)) {
            $result[] = implode(', ', flattenArray($item));
        } else {
            $result[] = (string) $item;
        }
    }
    return $result;
  }

}