<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sila_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id')->unsigned()->comment('所属模型');
            $table->string('name')->comment('分类名');
            $table->string('slug')->comment('英文名');
            $table->integer('parent_id')->unsigned()->comment('父分类 ID');
            $table->string('img')->comment('分类图片');
            $table->integer('status')->unsigned()->comment('状态(1=开启, 0=隐藏)');
            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
};
