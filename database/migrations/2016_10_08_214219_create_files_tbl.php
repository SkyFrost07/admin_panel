<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('url');
            $table->string('type', 32)->default('image');
            $table->string('mimetype', 32);
            $table->integer('author_id')->unsigned()->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
        
        Schema::table('users', function ($table) {
            $table->foreign('image_id')->references('id')->on('files')->onDelete('set null');
        });
        
        Schema::table('taxs', function ($table) {
           $table->foreign('image_id')->references('id')->on('files')->onDelete('set null'); 
        });
        
        Schema::table('posts', function ($table) {
            $table->foreign('thumb_id')->references('id')->on('files')->onDelete('set null'); 
        });
        
        Schema::table('medias', function ($table) {
            $table->foreign('thumb_id')->references('id')->on('files')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropForeign('users_image_id_foreign');
        });
        Schema::table('taxs', function ($table) {
           $table->dropForeign('taxs_image_id_foreign');
        });
        Schema::table('posts', function ($table) {
           $table->dropForeign('posts_thumb_id_foreign');
        });
        Schema::table('medias', function ($table) {
           $table->dropForeign('medias_thumb_id_foreign');
        });
        Schema::dropIfExists('files');
    }
}
