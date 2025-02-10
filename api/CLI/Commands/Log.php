<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Log extends Command {
  
  private $logFile = RABBIT_LOG_DIRECTORY . "/" . RABBIT_LOG_FILENAME . '.log';

  public function handleLogCommand($arrayOptions){
    $clear = (in_array('--clear', $arrayOptions)) ? true : false;
    if($clear) {
      $this->clearLog($this->logFile);
    } else {
      $this->showLog($this->logFile);
    }
  }
  
  private function showLog($logFile){    
    $content = file_get_contents($logFile);

    // Verificar si la lectura fue exitosa
    if ($content !== false) {
      echo $content;
    } else {
      echo "No se pudo leer el archivo de log.\n";
    }
  }

  function clearLog($logFile) {
    // Sobrescribir el archivo con una cadena vacía, lo que limpia su contenido
    if (file_put_contents($logFile, '') !== false) {
        echo "El archivo de log ha sido limpiado.\n";
    } else {
        echo "No se pudo limpiar el archivo de log.\n";
    }
  }

}