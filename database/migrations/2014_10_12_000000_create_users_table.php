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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role_id')->unsigned()->nullable();
            $table->tinyInteger('gender');
            $table->timestamp('birth')->nullable();
            $table->integer('image_id')->unsigned()->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('resetPasswdToken');
            $table->bigInteger('resetPasswdExpires');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
