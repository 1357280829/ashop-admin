<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no')->comment('订单编号');
            $table->string('taking_code')->nullable()->comment('自取号');
            $table->string('phone')->comment('联系电话');
            $table->string('arrived_time')->comment('自提时间');
            $table->json('products')->comment('商品快照');
            $table->decimal('total_price', 10, 2)->default(0.00)->comment('合计价');
            $table->unsignedTinyInteger('is_paid')->default(0)->comment('是否支付');
            $table->text('remark')->nullable()->comment('备注');
            $table->unsignedBigInteger('wechat_user_id')->comment('微信用户id');
            $table->unsignedBigInteger('admin_user_id')->comment('后台账号id');
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
        Schema::dropIfExists('orders');
    }
}
