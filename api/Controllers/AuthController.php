<?php 

namespace Rabbit\Controllers;

use Rabbit\Core\BaseController;
use Rabbit\Validators\StatusValidator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController{

    public function getBearerToken(){
      $issuedAt = time();
      $expiration = $issuedAt + TOKEN_EXPIRATION_TIME;
      $secretKey = JWT_SECRET_KEY;
      $body = $this->request->getBody();
      $userId = $body['userId'];
      // Crear el payload
      $payload = [
          'iss' => 'php-rabbit.com',  // Issuer
          'aud' => 'php-rabbit.com',  // Audience
          'iat' => $issuedAt,          // Issued at
          'exp' => $expiration,        // Expiration time
          'sub' => $userId             // Subject (ID del usuario)
      ];

      
      $JWTToken = JWT::encode($payload, $secretKey, 'HS256');

      $data = [
        'userId' => $userId, 
        'auth' => $JWTToken
      ];
        
      $this->response->withStatus200($data);
    }

}