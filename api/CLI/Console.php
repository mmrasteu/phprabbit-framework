<?php 

namespace Rabbit\CLI;

use Rabbit\CLI\Commands\Make;
use Rabbit\CLI\Commands\Help;
use Rabbit\CLI\Commands\Serve;

class Console {

    protected $commands = [];

    public function __construct() {
        // Registra los comandos disponibles
        $this->commands = [
            'make'      => 'handleMakeCommand',
            'serve'     => 'execPHPServe',
            'help'      => 'showHelp'
        ];
    }

    public function run($argv) {
        $command = $argv[1] ?? 'help';  // Obtiene el comando
        $arg1 = $argv[2] ?? '';         // Primer argumento
        $arg2 = $argv[3] ?? '';         // Segundo argumento

        // Llama al método correspondiente
        if (array_key_exists($command, $this->commands)) {
            $method = $this->commands[$command];
            $this->$method($arg1, $arg2);
        } else {
            echo "Command not found";
            $this->showHelp();
        }
    }

    protected function execPHPServe(){
        $command = new Serve();
        $command->execPHPServe();
    }

    protected function showHelp() {
        $command = new Help();
        $command->showHelp();
    }

    protected function handleMakeCommand() {
        $command = new Make();
        $command->handleMakeCommand();
    }

}