<?php 

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class Help extends Command {

  public function showHelp(){
    echo "Comandos disponibles:\n";
    echo "  make controller {nombre}\n";
    echo "      Crea un controlador\n";
    echo "  make validator {nombre}\n";
    echo "      Crea un validador\n";
    echo "  make model {nombre} [--no-migration]\n";
    echo "      Crea un modelo con su migración asociada (Con --no-migration no se crea la migración)\n";
    echo "  make migration {nombre}\n";
    echo "      Crea una migración\n";
    echo "  serve\n";
    echo "      Inicia un servidor local para pruebas\n";
    echo "  help\n";
    echo "      Muestra esta lista de comandos\n";
  }

}