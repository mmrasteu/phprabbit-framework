<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Log extends Command {
  
  private $logFile = RABBIT_LOG_DIRECTORY . "/" . RABBIT_LOG_FILENAME . '.log';

  public function handleLogCommand($arrayOptions){
    $clear = (array_key_exists('--clear', $arrayOptions)) ? true : false;
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
      echo _t("log.error.read") . "\n";
    }
  }

  function clearLog($logFile) {
    // Sobrescribir el archivo con una cadena vacía, lo que limpia su contenido
    if (file_put_contents($logFile, '') !== false) {
        echo _t("log.success.clear") . "\n";
    } else {
        echo _t("log.error.clear") . "\n";
    }
  }

}