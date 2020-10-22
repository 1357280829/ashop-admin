<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiniProgramPaymentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  小程序支付预订单表
        Schema::create('mini_program_payment_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id')->comment('后台账号id');
            $table->unsignedBigInteger('wechat_user_id')->comment('微信用户id');
            $table->string('openid')->comment('小程序openid');
            $table->unsignedTinyInteger('is_success')->default(0)->comment('是否创建预订单成功');
            $table->string('fail_code')->nullable()->comment('失败状态码');
            $table->string('fail_message')->nullable()->comment('失败信息');
            $table->string('prepay_id')->nullable()->comment('预订单标识');
            $table->json('result')->comment('支付预订单');
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
        Schema::dropIfExists('mini_program_payment_orders');
    }
}
