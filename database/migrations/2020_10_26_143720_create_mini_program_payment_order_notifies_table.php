<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiniProgramPaymentOrderNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  小程序支付回调表
        Schema::create('mini_program_payment_order_notifies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id')->default(0)->comment('后台账号id');
            $table->unsignedBigInteger('wechat_user_id')->default(0)->comment('微信用户id');
            $table->unsignedBigInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedTinyInteger('is_success')->default(0)->comment('是否支付成功');
            $table->string('fail_code')->nullable()->comment('失败状态码');
            $table->string('fail_message')->nullable()->comment('失败信息');
            $table->json('result')->comment('支付回调');
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
        Schema::dropIfExists('mini_program_payment_order_notifies');
    }
}
