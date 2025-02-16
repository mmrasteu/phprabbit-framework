<?php 

namespace Rabbit\CLI\Commands;

use Exception;

class Command {

  public function __construct(){

  }

  public function argumentException($msg='') {
    echo $msg."\n\n";
    throw new Exception($msg);
  }

}