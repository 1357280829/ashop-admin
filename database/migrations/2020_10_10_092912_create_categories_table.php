<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  分类表
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('分类名');
            $table->unsignedInteger('sort')->default(0)->comment('自定义排序');
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
        Schema::dropIfExists('categories');
    }
}
