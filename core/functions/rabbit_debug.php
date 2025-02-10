<?php 

function rabbit_debug($msg, $echo=false, $exit=false)
{
    // Ruta de la carpeta donde se guardarán los logs
    $logDirectory = RABBIT_LOG_DIRECTORY;
    $logFile = RABBIT_LOG_DIRECTORY . "/" . RABBIT_LOG_FILENAME . '.log';

    // Verificar si la carpeta existe, si no, crearla
    if (!is_dir($logDirectory)) {
        mkdir($logDirectory, 0777, true); // Crear la carpeta si no existe
    }

    // Formatear el mensaje de log con la fecha y hora
    $date = date('Y-m-d H:i:s');
    $logMessage = "[$date] - $msg\n";

    // Escribir el mensaje en el archivo de log (modo 'a' para agregar al final)
    file_put_contents($logFile, $logMessage, FILE_APPEND);
    if($echo){
      echo $msg . "\n";
    }
    
    if($exit) {
      die();
    }
}