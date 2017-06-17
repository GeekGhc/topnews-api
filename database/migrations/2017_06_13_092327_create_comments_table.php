<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');//评论的id
            $table->unsignedInteger('user_id');//用户的id
            $table->unsignedInteger('to_user_id');//用户的id
            $table->unsignedInteger('news_id');//新闻的id
            $table->text('body');//评论的内容
            $table->unsignedInteger('parent_id')->nullable();//上一级评论id
            $table->smallInteger('level')->default(1);//评论的层级
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
