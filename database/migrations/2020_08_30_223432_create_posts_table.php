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
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->unsignedBigInteger('user_id');
            $table->json('review_scores')->nullable();
            $table->integer('max_review_score')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->text('review_call_out')->nullable();
            $table->boolean('published')->default(0);
            $table->enum('type',['review','tutorial','news'])->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
