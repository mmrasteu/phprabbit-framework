<?php

namespace Rabbit\Http;

use Rabbit\Core\Render;
use Rabbit\Interfaces\ResponseInterface;

class Response implements ResponseInterface {
    
    private $render;

    public function __get($name) {
        if (method_exists($this, $name)) {
            return $this->{$name}();
        }
        throw new Exception("Undefined property: " . static::class . "::$name");
    }
    
    /**
     * Genera una respuesta con el código de estado 200 (OK).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * 
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus200(
        array $data = [],
        string $message = '200 - Success',
        string $title = 'Success'
    ): Render {
        $renderData = [
            'status' => 200,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ];

        $render = new Render($renderData);
        $render();
    }

    public function withStatus201(
        array $data = [], 
        string $message = '201 - Created', 
        string $title = 'Created'
    ): Render {
        $renderData = [
            'status' => 201,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ];
        $render = new Render($renderData);
        $render();
    }
    
    
    public function withStatus300(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '300 - Multiple Choices',
        string $title = 'Multiple Choices'
    ): Render {
        $renderData = [
            'status' => 300,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus301(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '301 - Moved Permanently',
        string $title = 'Moved Permanently'
    ): Render {
        $renderData = [
            'status' => 301,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus302(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '302 - Found',
        string $title = 'Found'
    ): Render {
        $renderData = [
            'status' => 302,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus303(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '303 - See Other',
        string $title = 'See Other'
    ): Render {
        $renderData = [
            'status' => 303,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus304(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '304 - Not Modified',
        string $title = 'Not Modified'
    ): Render {
        $renderData = [
            'status' => 304,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus400(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '400 - Bad Request',
        string $title = 'Bad Request'
    ): Render {
        $renderData = [
            'status' => 400,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];

        $render = new Render($renderData);
        $render();
    }

    public function withStatus401(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '401 - Unauthorized',
        string $title = 'Unauthorized'
    ): Render {
        
        $renderData = [
            'status' => 401,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        
        $render = new Render($renderData);
        $render();
    }

    public function withStatus403(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '403 - Forbidden',
        string $title = 'Forbidden'
    ): Render {
        $renderData = [
            'status' => 403,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus404(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '404 - Not Found',
        string $title = 'Not Found'
    ): Render {
        $renderData = [
            'status' => 404,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus405(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '405 - Method Not Allowed',
        string $title = 'Method Not Allowed'
    ): Render {
        $renderData = [
            'status' => 405,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus500(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '500 - Internal Server Error',
        string $title = 'Internal Server Error'
    ): Render {
        $renderData = [
            'status' => 500,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus502(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '502 - Bad Gateway',
        string $title = 'Bad Gateway'
    ): Render {
        $renderData = [
            'status' => 502,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus503(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '503 - Service Unavailable',
        string $title = 'Service Unavailable'
    ): Render {
        $renderData = [
            'status' => 503,
            'title' => $title,
            'message' => $message,
            'errors' => [
                'message' => $errorMessage,
                'details' => $errorDetails
            ]
        ];
        $render = new Render($renderData);
        $render();
    }

    public function withStatus(
        int $status,
        string $title,
        string $message,
        array $data
    ): Render {
        $renderData = [
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ];
        $render = new Render($renderData);
        $render();
    }
}
