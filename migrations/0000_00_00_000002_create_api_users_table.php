<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class create_api_users_table {
  public function up() {
    Capsule::schema()->create('api_users', function($table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->unsignedInteger('role_id');
      $table->foreign('role_id')->references('id')->on('api_users_role')->onDelete('cascade');
      $table->timestamps();
    });

    Capsule::table('api_users')->insert([
      'name' => ADMIN_USERNAME,  // Reemplazar por una constante si deseas
      'email' => ADMIN_EMAIL,  // Reemplazar por una constante
      'password' => password_hash(ADMIN_PASSWORD, PASSWORD_BCRYPT),  // Reemplazar por una constante
      'role_id' => 1,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
    ]);

  }

  public function down() {
    Capsule::schema()->drop('api_users');
  }
}
