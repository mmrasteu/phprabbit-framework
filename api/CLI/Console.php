<?php 

namespace Rabbit\CLI;

use Rabbit\CLI\Commands\Make;
use Rabbit\CLI\Commands\Help;
use Rabbit\CLI\Commands\Serve;
use Rabbit\CLI\Commands\Migrate;
use Rabbit\CLI\Commands\Log;
use Rabbit\CLI\Commands\Env;
use Rabbit\CLI\Commands\Route;
use Rabbit\CLI\Commands\GenerateSwagger;
use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\DatabaseException;
use Rabbit\Exceptions\ExceptionHandler;

class Console {

  protected $commands = [];
  protected $helperCommand = '';

  public function __construct() {
    // Registra los comandos disponibles
    $this->helperCommand = new Help();
    $this->commands = [
      'make'              => 'make',
      'migrate'           => 'migrate',
      'serve'             => 'serve',
      'log'               => 'log',
      'env'               => 'env',
      'route'               => 'route',
      'generate:swagger'  => 'generateSwagger',
      'help'              => 'help'
    ];
  }

  public function run($argv) {
    $command = $argv[1] ?? 'help';  // Obtiene el comando
    $arg1 = $argv[2] ?? '';     // Primer argumento
    $arg2 = $argv[3] ?? '';     // Segundo argumento
    $arrayOptions = [];       // Inicializamos $arrayOptions como un array vacío
  
    // Filtramos los argumentos que comienzan con '--'
    foreach ($argv as $arg) {
      if (strpos($arg, '--') === 0) {
        $arrayOptions[] = $arg;  // Agregamos a $arrayOptions los argumentos que empiezan con '--'
      }
    }
  
    // Llama al método correspondiente
    try {
      if (array_key_exists($command, $this->commands)) {
        $method = $this->commands[$command];
        $this->$method($arg1, $arg2, $arrayOptions);  // Pasamos $arrayOptions como un array de opciones
      } else {
        $msg = _t("Command not found");
        rabbit_debug($msg, true);
        $this->helperCommand->showHelp();
      }
    } catch(Exception $e) {
      $this->helperCommand->showHelp();
    }
  }

  protected function serve(){
    $command = new Serve();
    $command->execPHPServe();
  }

  protected function help() {
    $this->helperCommand->showHelp();
  }

  protected function make($arg1, $arg2, $arrayOptions) {
    try {
      $command = new Make();
      $command->handleMakeCommand($arg1, $arg2, $arrayOptions);
    } catch(BaseException $e) {
      ExceptionHandler::handle($e);
      $this->helperCommand->showHelp();
    }  
  }

  protected function migrate($arg1=false, $arg2=false, $arrayOptions) {
    try {
      $command = new Migrate();
      $command->handleMigrateCommand($arg1);
    } catch(DatabaseException $e) {
      $msg = _t("An error has occurred with the database");
      rabbit_debug($msg, true);
      $this->helperCommand->showHelp();
    } catch(BaseException $e) {
      $msg = _t("An error has occurred");
      rabbit_debug($msg, true);
      $this->helperCommand->showHelp();
    }
    
  }

  protected function log($arg1=false, $arg2=false, $arrayOptions) { 
    try {
    $command = new Log();
    $command->handleLogCommand($arrayOptions);
    } catch(BaseException $e) {
      $msg = _t("An error has occurred");
      rabbit_debug($msg, true);
      $this->helperCommand->showHelp();
    }
  }

  protected function env($arg1=false, $arg2=false, $arrayOptions) { 
    try {
    $command = new Env();
    $command->handleEnvCommand();
    } catch(BaseException $e) {
      $msg = _t("An error has occurred");
      rabbit_debug($msg, true);
      $this->helperCommand->showHelp();
    }
  }

  protected function route($arg1=false, $arg2=false, $arrayOptions) { 
    try {
    $command = new Route();
    $command->handleRouteCommand($arrayOptions);
    } catch(BaseException $e) {
      $msg = _t("An error has occurred");
      rabbit_debug($msg, true);
      $this->helperCommand->showHelp();
    }
  }

  protected function generateSwagger($arg1=false, $arg2=false, $arrayOptions) { 
    try {
    $command = new GenerateSwagger();
    $command->handleGenerateSwaggerCommand();
    } catch(BaseException $e) {
      $msg = _t("An error has occurred");
      rabbit_debug($msg, true);
      $this->helperCommand->showHelp();
    }
  }

}
