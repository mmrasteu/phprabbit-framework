<?php

namespace Rabbit\Middlewares;

use Rabbit\Http\Response;
use Rabbit\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class BearerTokenMiddleware {

    /**
     * Maneja la validación del Bearer Token.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, Response $response, callable $next): mixed {
        // Obtener el token de la cabecera Authorization
        $authorizationHeader = $request->getHeader('Authorization');
        
        // Verificar si se encuentra el token Bearer
        if (!$authorizationHeader || strpos($authorizationHeader, 'Bearer ') !== 0) {
            $response->withStatus401('Invalid token');
            exit;
        }
        // Extraer el token Bearer
        $token = substr($authorizationHeader, 7); 

        if (!$this->validateToken($token)) {
            $response->withStatus401('Invalid token');
            exit;
        }

        // Si el token es válido, permitir el acceso
        return $next($request, $response);
    }

    /**
     * Validación del Bearer Token (puedes usar JWT o llamar a un servidor OAuth)
     *
     * @param string $token
     * @return bool
     */
    private function validateToken($token): bool {
        try {
            $decoded = JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
            return true;  // El token es válido
        } catch (Exception $e) {
            // Opcionalmente, registra el error
            error_log('JWT Decode Error: ' . $e->getMessage());
            return false;  // El token es inválido
        }
    }
}
