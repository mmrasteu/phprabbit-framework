<?php

namespace Rabbit\Core;

use Rabbit\Http\Request;
use Rabbit\Core\Container;
use Exception;

class WebView
{
    public function handleRequest(Request $request)
    {   
        // Verifica si la ruta solicitada es '/docs'
        $uri = strtok($request->getUri(), '?');
        if ($uri== '/docs') {
            // Incluye el archivo swagger.php desde la carpeta /public
            $this->renderSwagger();
        }
    }

    private function renderSwagger()
    {
        // Asegúrate de que el archivo swagger.php exista antes de incluirlo
        $swaggerFile = BASE_PATH . '/public/swagger.php';

        if (file_exists($swaggerFile)) {
            include($swaggerFile);
            exit();
        } else {
            // Si el archivo no existe, muestra un mensaje de error
            echo "Error: El archivo swagger.php no se encuentra.";
        }
    }
}
