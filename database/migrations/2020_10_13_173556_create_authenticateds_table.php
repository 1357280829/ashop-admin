<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  认证者表
        Schema::create('authenticateds', function (Blueprint $table) {
            $table->id();
            $table->string('authenticate_type')->comment('认证类型;mini_program:小程序认证,official_account:公众号认证');
            $table->string('authenticated_user_model')->comment('认证者用户模型');
            $table->unsignedBigInteger('authenticated_user_id')->comment('认证者用户id');
            $table->string('token')->comment('token');
            $table->unsignedInteger('ttl')->default(0)->comment('生命周期(单位:秒)，0表示无限');
            $table->timestamp('expired_at')->nullable()->comment('失效时间，空表示无限');
            $table->unsignedBigInteger('admin_user_id')->comment('后台账号id');
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
        Schema::dropIfExists('authenticateds');
    }
}
