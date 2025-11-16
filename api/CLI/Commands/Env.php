<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Env extends Command {
  
  public function handleEnvCommand(){
      $this->showEnv();
  }

  private function showEnv() {
    echo _t("generic.info.env_title") . ": " . ENVIROMENT . "\n";
  }

}