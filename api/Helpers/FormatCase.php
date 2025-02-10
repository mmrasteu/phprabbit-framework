<?php 

namespace Rabbit\Helpers;

class FormatCase {

  public function transform(string $formatCase, array $data){
    switch($formatCase) {
      case 'camelCase':
        return $this->convertToCamelCase($data);
        break;
      case 'snake_case':
        return $this->convertToSnakeCase($data);
        break;
      case 'PascalCase':
        return $this->convertToPascalCase($data);
        break;
      default:
        return $data;
    }
  }

  private function convertToCamelCase(array $data){
    $convertedData = [];

    foreach ($data as $key => $value) {
        $newKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

        if (is_array($value)) {
            $convertedData[$newKey] = $this->convertToCamelCase($value);
        } else {
            $convertedData[$newKey] = $value;
        }
    }

    return $convertedData;
  }

  private function convertToSnakeCase(array $data){
    $convertedData = [];

    foreach ($data as $key => $value) {
        // Convertir la clave a snake_case
        $newKey = strtolower(preg_replace('/[A-Z]/', '_$0', $key)); // Cambia las mayúsculas por un guion bajo
        $newKey = ltrim($newKey, '_'); // Eliminar guion bajo extra al principio
        $newKey = str_replace(' ', '_', $newKey); // Reemplazar espacios por guiones bajos
        $newKey = preg_replace('/_+/', '_', $newKey); // Eliminar guiones bajos consecutivos

        // Si el valor es un array, también lo convertimos recursivamente
        if (is_array($value)) {
            $convertedData[$newKey] = $this->convertToSnakeCase($value);
        } else {
            $convertedData[$newKey] = $value;
        }
    }

    return $convertedData;
  }

  private function convertToPascalCase(array $data){
    $convertedData = [];

    foreach ($data as $key => $value) {
        // Convertir la clave a PascalCase
        $newKey = preg_replace_callback('/(?:^|_|\s)([a-z])/', function ($matches) {
          return strtoupper($matches[1]);
      }, $key);
      
      // Eliminar los guiones bajos y los espacios
      $newKey = str_replace(['_', ' '], '', $newKey);

      // Si el valor es un array, también lo convertimos recursivamente
      if (is_array($value)) {
          $convertedData[$newKey] = $this->convertToPascalCase($value);
      } else {
          $convertedData[$newKey] = $value;
      }
    }

    return $convertedData;
  }

  public static function convertTextToSnakeCase(string $text) {
    $newText = strtolower(preg_replace('/[A-Z]/', '_$0', $text)); // Cambia las mayúsculas por un guion bajo
    $newText = ltrim($newText, '_'); // Eliminar guion bajo extra al principio
    $newText = str_replace(' ', '_', $newText); // Reemplazar espacios por guiones bajos
    $newText = preg_replace('/_+/', '_', $newText); // Eliminar guiones bajos consecutivos
    return $newText;
  }

  public static function convertTextToPascalCase(string $text) {
    $newText = preg_replace_callback('/(?:^|_|\s)([a-z])/', function ($matches) {
      return strtoupper($matches[1]);
    }, $text);
    
    // Eliminar los guiones bajos y los espacios
    $newText = str_replace(['_', ' '], '', $newText);
    return $newText;
  }

}