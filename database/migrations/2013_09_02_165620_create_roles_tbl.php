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
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('label');
            $table->string('higher')->nullable();
        });
        
        Schema::table('caps', function($table){
           $table->foreign('higher')->references('name')->on('caps')->onDelete('set null'); 
        });

        Schema::create('role_cap', function(Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('cap_id')->unsigned();
            $table->primary(['role_id', 'cap_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('cap_id')->references('id')->on('caps')->onDelete('cascade');
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
