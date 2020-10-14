<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('商品名');
            $table->string('cover_url')->nullable()->comment('封面url');
            $table->decimal('sale_price', 10, 2)->default(0.00)->comment('销售价');
            $table->decimal('packing_price', 10, 2)->default(0.00)->comment('包装费');
            $table->unsignedInteger('stock')->default(1)->comment('库存');
            $table->unsignedTinyInteger('is_on')->default(0)->comment('是否上架');
            $table->unsignedInteger('sort')->default(0)->comment('自定义排序值');
            $table->string('unit_name')->comment('单位名');
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
        Schema::dropIfExists('products');
    }
}
