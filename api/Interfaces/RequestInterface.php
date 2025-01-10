<?php

namespace Rabbit\Interfaces;

// Definición del Interface para la solicitud
interface RequestInterface
{
    // Obtener el método HTTP de la solicitud (GET, POST, PUT, DELETE, etc.)
    public function getMethod(): string;

    // Obtener el parámetro de la URL (query string) o por defecto null si no existe
    public function getParam(string $key): ?string;

    // Obtener el cuerpo de la solicitud, lo que se envía en el body (POST, PUT)
    public function getBody(): array;

    // Obtener el valor de una cabecera específica
    public function getHeader(string $header): ?string;

    // Obtener todos los parámetros de la solicitud
    public function getParams(): array;

    // Método para obtener la URI completa de la solicitud
    public function getUri(): string;
}
