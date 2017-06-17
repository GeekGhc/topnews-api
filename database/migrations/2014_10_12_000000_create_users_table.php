<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');//用户id
            $table->string('name');//用户名
            $table->string('avatar');//用户头像
            $table->string('password');//用户密码
            $table->text('desc')->nullable();//用户说明
            $table->string('email')->unique();//用户邮箱
            $table->string('phone')->nullable();//用户手机
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
