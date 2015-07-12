<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('username', 45)->unique();
            $table->string('email', 65)->unique();
            $table->string('password', 60);
            $table->string('code', 60);
            $table->boolean('manual_register')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_superuser')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }
}
