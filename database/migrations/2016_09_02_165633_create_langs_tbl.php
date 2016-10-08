<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('langs', function(Blueprint $table){
           $table->increments('id');
           $table->string('name');
           $table->string('code', 2)->unique();
           $table->string('icon');
           $table->string('folder');
           $table->string('unit', 5);
           $table->float('ratio_currency')->default(1.00);
           $table->integer('order');
           $table->tinyInteger('status')->default(1);
           $table->tinyInteger('default')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('langs');
    }
}
