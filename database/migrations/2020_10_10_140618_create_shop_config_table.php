<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  商家配置表
        Schema::create('shop_config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->comment('配置键');
            $table->string('name')->nullable()->comment('配置名');
            $table->text('value')->comment('配置值');
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
        Schema::dropIfExists('shop_config');
    }
}
