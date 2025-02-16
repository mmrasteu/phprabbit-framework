<?php

namespace Rabbit\Models;

use Illuminate\Database\Eloquent\Model;

class ApiUsersModel extends Model {
  protected $table = 'api_users';
  protected $primaryKey = 'id';
  public $timestamps = true;

  protected $fillable = ['name'];

  public static function getAllApiUsers() {
    return self::all();
  }

  public static function getApiUsersById($id) {
    return self::find($id);
  }

  public static function createApiUsers($data) {
    return self::create($data);
  }

  public static function updateApiUsers($id, $data) {
    $user = self::find($id);
    if ($user) {
      $user->update($data);
      return $user;
    }
    return null;
  }

  public static function deleteApiUsers($id) {
    $user = self::find($id);
    if ($user) {
      $user->delete();
      return true;
    }
    return false;
  }

  public static function getByNameAndPassword($name, $password) {
    // Buscar al usuario por nombre
    $user = self::where('name', $name)->first();

    // Verificar la contraseña con password_verify
    if ($user && password_verify($password, $user->password)) {
      return self::find($user->id);
    }

    // Si no se encuentra el usuario o la contraseña no coincide
    return null;
  }

}
