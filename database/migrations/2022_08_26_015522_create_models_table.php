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
        Schema::create('sila_models', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('模型名');
            $table->string('table_name', 50)->comment('模型表名');
            $table->string('description', 255)->comment('模型描述');
            $table->integer('status')->comment('模型状态(1=开启, 0=关闭)');
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
        Schema::dropIfExists('models');
    }
};
