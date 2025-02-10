<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Serve extends Command {

  private $publicDir = BASE_PATH . '/public';

  public function execPHPServe() {
    exec("php -S localhost:8000 -t $this->publicDir");
  }

}