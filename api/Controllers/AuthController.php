<?php 

namespace Rabbit\Controllers;

use Rabbit\Core\BaseController;
use Rabbit\Controllers\ApiUsersController;
use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\DatabaseException;
use Rabbit\Exceptions\ExceptionHandler;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @OA\Info(title="Mi API", version="1.0")
 *
 * @OA\SecurityScheme(
 *   securityScheme="BasicAuth",
 *   type="http",
 *   scheme="basic"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="BearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */

class AuthController extends BaseController{
    /**
     * @OA\Post(
     *   path="/api/auth",
     *   summary="Autenticar usuario y obtener JWT",
     *   tags={"API Auth"}, 
     *   security={{"BasicAuth":{}}}, 
     *   @OA\Response(
     *     response=200,
     *     description="Inicio de sesión exitoso",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=200),
     *       @OA\Property(property="title", type="string", example="Success"),
     *       @OA\Property(property="message", type="string", example="200 - Success"),
     *       @OA\Property(property="data", type="object",
     *         @OA\Property(property="userId", type="integer", example=1),
     *         @OA\Property(property="auth", type="string", example="**************************")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Credenciales inválidas",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=401),
     *       @OA\Property(property="title", type="string", example="Unauthorized"),
     *       @OA\Property(property="message", type="string", example="401 - Unauthorized"),
     *       @OA\Property(property="errors", type="object",
     *         @OA\Property(property="message", type="string", example=""),
     *         @OA\Property(property="details", type="array",
     *           @OA\Items(type="string", example="")
     *         )
     *       )
     *     )
     *   )
     * )
     */

    public function getBearerToken(){
      try{
        // Obtener el encabezado Authorization de la solicitud
        $authHeader = $this->request->getHeader('Authorization');
        // Verificar que el encabezado esté presente y en el formato esperado (Basic Auth)
        if (!$authHeader || strpos($authHeader, 'Basic ') !== 0) {
          // Si no es un encabezado Basic Auth, retornar un error
          $this->response->withStatus401();
        } 
        
        $base64Credentials = substr($authHeader, 6);
        $decoded = base64_decode($base64Credentials);
        
        // Separar el usuario y la contraseña (formato "usuario:contraseña")
        list($user, $password) = explode(":", $decoded);
        
        $authUser = ApiUsersController::loggingIn($user, $password);
        if(is_null($authUser)) {
          $this->response->withStatus401();
        }

        $roleName = ApiUsersController::getRoleNameById($authUser->role_id);

        $issuedAt = time();
        $expiration = $issuedAt + TOKEN_EXPIRATION_TIME;
        $secretKey = JWT_SECRET_KEY;

        // Crear el payload
        $payload = [
            'iss' => APP_NAME,  // Issuer
            'aud' => APP_NAME,  // Audience
            'iat' => $issuedAt,          // Issued at
            'exp' => $expiration,        // Expiration time
            'sub' => $authUser->id,     // Subject (ID del usuario)
            'role' => $roleName
        ];

        
        $JWTToken = JWT::encode($payload, $secretKey, 'HS256');

        $data = [
          'userId' => $authUser['id'], 
          'auth' => $JWTToken
        ];
          
        $this->response->withStatus200($data);

      } catch (DatabaseException $e) {
        ExceptionHandler::handle($e);
        $this->response->withStatus500($e->getMessage());
      } catch (BaseException $e) {
        ExceptionHandler::handle($e);
        $this->response->withStatus500($e->getMessage());
      }
    }
}