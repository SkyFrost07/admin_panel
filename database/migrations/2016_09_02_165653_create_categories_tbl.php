<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxs', function(Blueprint $table){
           $table->increments('id');
           $table->integer('image_id')->unsigned()->nullable();
           $table->string('type', 30)->default('cat');
           $table->integer('parent_id')->unsigned()->nullable();
           $table->string('parent_ids');
           $table->integer('order');
           $table->integer('count');
           $table->integer('status')->default(1);
           $table->timestamps();
           $table->foreign('parent_id')->references('id')->on('taxs')->onDelete('set null');
        });
        
        Schema::create('tax_desc', function(Blueprint $table){
           $table->integer('tax_id')->unsigned();
           $table->string('lang_code', 2);
           $table->string('name');
           $table->string('slug');
           $table->text('description', 500);
           $table->string('meta_keyword', 255);
           $table->text('meta_desc', 500);
           $table->primary(['tax_id', 'lang_code']);
           $table->timestamps();
           $table->foreign('tax_id')->references('id')->on('taxs')->onDelete('cascade');
           $table->foreign('lang_code')->references('code')->on('langs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxs');
        Schema::dropIfExists('tax_desc');
    }
}
