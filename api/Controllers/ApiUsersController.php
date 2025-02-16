<?php

namespace Rabbit\Controllers;

use Rabbit\Core\BaseController;
use Rabbit\Models\ApiUsersModel;
use Rabbit\Models\ApiUsersRoleModel;
use Rabbit\Validators\ApiUsersValidator;
use Rabbit\Exceptions\BaseException;
use Rabbit\Exceptions\ValidationException;
use Rabbit\Exceptions\DatabaseException;
use Rabbit\Exceptions\ExceptionHandler;

class ApiUsersController extends BaseController {
  /**
   * @OA\Ignore()
   */
  public function getApiUsers($id) {
    try {
      $this->validate(new ApiUsersValidator($this->request, $this->response));

      $data = ApiUsersModel::getApiUsersByIndex($id);

      $this->response->withStatus200($data);
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
  /**
   * @OA\Ignore()
   */
  public function getAllApiUsers() {
    try {
      $this->validate(new ApiUsersValidator($this->request, $this->response));

      $data = ApiUsersModel::getAllApiUsers();

      $this->response->withStatus200($data);
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
  /**
   * @OA\Ignore()
   */
  public function setApiUsers($data) {
    try {
      $this->validate(new ApiUsersValidator($this->request, $this->response));

      $data = json_decode($data, true);

      if (!isset($data['name']) || empty($data['name'])) {
        throw new ValidationException("El campo 'name' es obligatorio.");
      }
      if (!isset($data['email']) || empty($data['email'])) {
          throw new ValidationException("El campo 'email' es obligatorio.");
      }
      if (!isset($data['password']) || empty($data['password'])) {
          throw new ValidationException("El campo 'password' es obligatorio.");
      }
      if (!isset($data['role_id']) || empty($data['role_id'])) {
          throw new ValidationException("El campo 'role_id' es obligatorio.");
      }

      $password = $data['password'];
      $data['password'] = password_hash($password, PASSWORD_BCRYPT);

      $data = ApiUsersModel::createApiUsers($data);

      $this->response->withStatus200($data);
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
  /**
   * @OA\Ignore()
   */
  public function updateApiUsers($id,$data) {
    try {
      $this->validate(new ApiUsersValidator($this->request, $this->response));

      $data = ApiUsersModel::updateApiUsers($id, $data);

      $this->response->withStatus200($data);
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
  /**
   * @OA\Ignore()
   */
  public function deleteApiUsers($id) {
    try {
      $this->validate(new ApiUsersValidator($this->request, $this->response));

      $data = ApiUsersModel::deleteApiUsers($id);

      $this->response->withStatus200($data);
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
  /**
   * @OA\Ignore()
   */
  public static function loggingIn($userName, $userPassword) {
    try {

      $data = ApiUsersModel::getByNameAndPassword($userName, $userPassword);

      return $data;
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }
  /**
   * @OA\Ignore()
   */
  public static function getRoleNameById($roleId) {
    try {

      $data = ApiUsersRoleModel::getApiUsersRoleById($roleId);

      return $data->name;
    } catch (ValidationException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus400($e->getMessage());
    } catch (DatabaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    } catch (BaseException $e) {
      ExceptionHandler::handle($e);
      $this->response->withStatus500($e->getMessage());
    }
  }

}

