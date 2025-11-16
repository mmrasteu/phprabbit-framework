<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Help extends Command {

  public function showHelp(){
    echo _t("console.info.help");
  }

}