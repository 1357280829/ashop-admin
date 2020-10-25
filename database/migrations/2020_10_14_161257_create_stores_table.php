<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  商家表
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('key')->comment('商家key');
            $table->unsignedBigInteger('admin_user_id')->comment('后台账号id');
            $table->string('business_license_code')->nullable()->comment('营业执照-组织机构代码');
            $table->string('business_license_name')->nullable()->comment('营业执照-名称');
            $table->unsignedTinyInteger('is_enable_bill_service')->default(0)->comment('是否开启发票服务');
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
        Schema::dropIfExists('stores');
    }
}
