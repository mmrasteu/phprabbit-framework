<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Make extends Command {

  public function handleMakeCommand($type){
    switch($type){
        case 'controller':
            echo "Create controller X";
            break;
        case 'help':
        default:
            echo "Show make helper";
            break;
    }
  }
  
}