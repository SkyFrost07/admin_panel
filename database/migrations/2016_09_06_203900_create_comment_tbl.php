<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('author_email');
            $table->string('author_name');
            $table->integer('author_id')->unsigned()->nullable();
            $table->string('author_ip');
            $table->text('content');
            $table->tinyInteger('status')->default(0);
            $table->string('agent')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
