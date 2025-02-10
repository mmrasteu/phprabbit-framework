<?php

namespace Rabbit\Models;

use Illuminate\Database\Eloquent\Model;

class ApiUsersRoleModel extends Model {
  protected $table = 'api_users_role';
  protected $primaryKey = 'id';
  public $timestamps = true;

  protected $fillable = ['name'];

  public static function getAllApiUsersRole() {
    return self::all();
  }

  public static function getApiUsersRoleById($id) {
    return self::find($id);
  }

  public static function createApiUsersRole($data) {
    return self::create($data);
  }

  public static function updateApiUsersRole($id, $data) {
    $user = self::find($id);
    if ($user) {
      $user->update($data);
      return $user;
    }
    return null;
  }

  public static function deleteApiUsersRole($id) {
    $user = self::find($id);
    if ($user) {
      $user->delete();
      return true;
    }
    return false;
  }

}
