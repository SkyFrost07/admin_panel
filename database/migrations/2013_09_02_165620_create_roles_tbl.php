<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTbl extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('name')->unique();
            $table->tinyInteger('default')->default(0);
        });
        
        Schema::create('caps', function(Blueprint $table) {
            $table->string('name', 32);
            $table->string('label');
            $table->string('higher')->nullable();
            $table->primary('name');
            $table->foreign('higher')->references('name')->on('caps')->onDelete('set null')->onUpdate('cascade'); 
        });

        Schema::create('role_cap', function(Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->string('cap_name', 32);
            $table->primary(['role_id', 'cap_name']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('cap_name')->references('name')->on('caps')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('caps');
        Schema::dropIfExists('role_cap');
    }

}
