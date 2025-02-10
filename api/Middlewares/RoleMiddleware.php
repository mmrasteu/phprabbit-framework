<?php
namespace Rabbit\Middlewares;

use Rabbit\Http\Response;
use Rabbit\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Rabbit\Exceptions\UnauthorizedException;
use Rabbit\Exceptions\ExceptionHandler;

class RoleMiddleware
{
    private $allowedRoles;

    // Aceptamos los roles permitidos como parámetro al crear la instancia
    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function handle(Request $request, Response $response, $next)
    {
        // Obtener el token JWT del header "Authorization"
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            $response->withStatus401('Authorization header missing');
        }

        // Extraer el token
        $jwt = str_replace('Bearer ', '', $authHeader);
        try {
            // Decodificar el JWT
            $decoded = $this->validateToken($jwt);
        } catch (UnauthorizedException $e) {
            ExceptionHandler::handle($e);
            $response->withStatus401('Invalid or expired token');
        }

        // Verificar el rol del usuario (que se encuentra en el JWT)
        $userRole = $decoded->role;

        // Verificar si el rol del usuario está en la lista de roles permitidos.
        // Si $this->allowedRoles esta vacio se asume que se permite el paso a todos los usuarios
        if (!empty($this->allowedRoles) && !in_array($userRole, $this->allowedRoles)) {
            $response->withStatus403('Insufficient permissions');
        }

        // Si el rol es permitido, seguir con la siguiente acción
        return $next($request, $response);
    }

    /**
     * Validación y decodificación del Bearer Token.
     *
     * Este método valida y decodifica un token JWT utilizando la clave secreta.
     * Si el token es válido y no ha expirado, devuelve el objeto decodificado.
     * Si el token no es válido o ha expirado, lanza una excepción UnauthorizedException.
     *
     * @param string $jwt El token JWT a validar y decodificar.
     * @return object El objeto decodificado del JWT.
     * @throws UnauthorizedException Si el token es inválido o ha expirado.
     */
    private function validateToken($jwt): object {
        try {
            return JWT::decode($jwt, new Key(JWT_SECRET_KEY, 'HS256'));
        } catch (\Exception $e) {
            throw new UnauthorizedException('Invalid or expired token');
        }
    }
}
