<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Help extends Command {

  public function showHelp(){
    echo "Comandos disponibles:\n";
    echo "  make [type]        Crea un archivo de tipo [controller, validator]\n";
    echo "  help               Muestra esta lista de comandos\n";
    echo "  serve              Inicia un servidor local para pruebas\n";
    echo "Pintar ayuda";
  }

}