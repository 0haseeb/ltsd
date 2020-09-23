<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('content')->nullable();
            $table->boolean('has_image')->default(0);
            $table->string('image')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('comment');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->timestamps();
        });

        // Schema::create('images', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('post_id')->unsigned();
        //     $table->string('image_path');
        //
        //     $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        //
        // });
        //
        // Schema::create('likes', function (Blueprint $table) {
        //     $table->integer('post_id')->unsigned();
        //     $table->integer('like_user_id')->unsigned();
        //
        //     $table->timestamps();
        //
        //     $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        //     $table->foreign('like_user_id')->references('id')->on('users')->onDelete('CASCADE');
        //
        //
        //     $table->primary(['post_id', 'like_user_id']);
        //
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('comments');
        // Schema::dropIfExists('post_images');
        // Schema::dropIfExists('post_likes');

    }
}
