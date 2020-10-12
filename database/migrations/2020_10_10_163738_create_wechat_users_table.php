<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  微信用户表
        Schema::create('wechat_users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable()->comment('用户昵称');
            $table->string('phone')->nullable()->comment('手机号');
            $table->string('unionid')->nullable()->comment('微信开放平台唯一标识');
            $table->string('openid_mini_program')->nullable()->comment('小程序openid');
            $table->string('openid_official_account')->nullable()->comment('公众号openid');
            $table->string('avatar_url')->nullable()->comment('用户头像url');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别;0:未知,1:男,2:女');
            $table->string('country')->nullable()->comment('用户所在国家');
            $table->string('province')->nullable()->comment('用户所在省份');
            $table->string('city')->nullable()->comment('用户所在城市');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_users');
    }
}
