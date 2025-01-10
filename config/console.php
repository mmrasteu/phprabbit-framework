<?php 

namespace Rabbit\Console;

# Clase Console para definir los comandos a usar con el comando rabbit

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

    protected function showHelp() {
        echo "Comandos disponibles:\n";
        echo "  make [type]        Crea un archivo de tipo [controller, validator, transformer]\n";
        echo "  help               Muestra esta lista de comandos\n";
        echo "Pintar ayuda";
    }

    protected function execPHPServe() {
        $publicDir = BASE_PATH . '/public';
        exec("php -S localhost:8000 -t $publicDir");
    }

    protected function handleMakeCommand($type){
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