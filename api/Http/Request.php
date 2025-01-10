<?php

namespace Rabbit\Http;

use Rabbit\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $method;
    private $queryParams;
    private $body;
    private $headers;

    public function __construct()
    {   
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->queryParams = $_GET;
        $this->body = json_decode(file_get_contents("php://input"), true) ?? [];
        $this->headers = getallheaders();
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParam(string $key): ?string
    {
        return $this->queryParams[$key] ?? null;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getHeader(string $header): ?string
    {
        return $this->headers[$header] ?? null;
    }

    public function getParams(): array
    {
        return array_merge($this->queryParams, $this->body);
    }

    public function getAllHeaders(): array
    {
        return $this->headers;
    }
}
