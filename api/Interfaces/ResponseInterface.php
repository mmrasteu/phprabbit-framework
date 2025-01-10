<?php

namespace Rabbit\Interfaces;

use Rabbit\Core\Render;

// Definición del Interface
interface ResponseInterface {

    /**
     * Genera una respuesta con el código de estado 200 (OK).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus200(
        array $data = [], 
        string $message = '200 - Success', 
        string $title = 'Success'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 201 (Created).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus201(
        array $data = [], 
        string $message = '201 - Created', 
        string $title = 'Created'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 300 (Multiple Choices).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus300(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '300 - Multiple Choices', 
        string $title = 'Multiple Choices'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 301 (Moved Permanently).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus301(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '301 - Moved Permanently', 
        string $title = 'Moved Permanently'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 302 (Found).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus302(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '302 - Found', 
        string $title = 'Found'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 303 (See Other).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus303(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '303 - See Other', 
        string $title = 'See Other'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 304 (Not Modified).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus304(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '304 - Not Modified', 
        string $title = 'Not Modified'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 400 (Bad Request).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus400(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '400 - Bad Request', 
        string $title = 'Bad Request'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 401 (Unauthorized).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus401(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '401 - Unauthorized', 
        string $title = 'Unauthorized'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 403 (Forbidden).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus403(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '403 - Forbidden', 
        string $title = 'Forbidden'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 404 (Not Found).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus404(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '404 - Not Found', 
        string $title = 'Not Found'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 405 (Method Not Allowed).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus405(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '405 - Method Not Allowed', 
        string $title = 'Method Not Allowed'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 500 (Internal Server Error).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus500(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '500 - Internal Server Error', 
        string $title = 'Internal Server Error'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 502 (Bad Gateway).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus502(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '502 - Bad Gateway', 
        string $title = 'Bad Gateway'
    ): Render;

    /**
     * Genera una respuesta con el código de estado 503 (Service Unavailable).
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withStatus503(
        string $errorMessage = '',
        array $errorDetails = [],
        string $message = '503 - Service Unavailable', 
        string $title = 'Service Unavailable'
    ): Render;

    /**
     * Genera una respuesta personalizada con un código de estado específico.
     *
     * @param array $data Datos adicionales a incluir en la respuesta.
     * @param string $message Mensaje de la respuesta.
     * @param string $title Título de la respuesta.
     * @param int $status Código de estado HTTP.
     * @return Render La instancia de la clase Render con los datos de la respuesta.
     */
    public function withCustomStatus(
        array $data, 
        string $message, 
        string $title, 
        int $status
    ): Render;
}
