<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
          $table->increments('id');
          $table->text('name');
          $table->timestamps();
        });
        Schema::create('post_tag', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('post_id')->unsigned();
          $table->integer('tag_id')->unsigned();
          $table->timestamps();
          $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
          $table->foreign('tag_id')->references('id')->on('tags')->onDelete('CASCADE');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('post_tag');
    }
}
