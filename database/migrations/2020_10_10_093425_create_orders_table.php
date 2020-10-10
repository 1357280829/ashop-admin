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
            $table->string('phone')->comment('联系电话');
            $table->timestamp('arrived_at')->comment('自提时间');
            $table->json('products')->comment('商品快照');
            $table->decimal('packing_price', 10, 2)->default(0.00)->comment('包装费');
            $table->decimal('delivery_price', 10, 2)->default(0.00)->comment('配送费');
            $table->decimal('total_price', 10, 2)->default(0.00)->comment('合计价');
            $table->text('remark')->nullable()->comment('备注');
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
