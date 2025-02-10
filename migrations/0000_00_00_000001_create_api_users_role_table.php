<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class create_api_users_role_table {
  public function up() {
    Capsule::schema()->create('api_users_role', function($table) {
      $table->increments('id');
      $table->string('name');
      $table->timestamps();
    });

    Capsule::table('api_users_role')->insert([
      'name' => 'api_user', // El nombre del rol por defecto
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
    ]);
  }

  public function down() {
    Capsule::schema()->drop('api_users_role');
  }
}
