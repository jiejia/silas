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
        Schema::create('sila_model_fields', function (Blueprint $table) {
            $table->id();
            $table->string('group', 100)->comment('字段分组');
            $table->string('comments', 255)->comment('字段描述');
            $table->string('table_field_name', 100)->comment('字段名');
            $table->integer('model_id')->unsigned()->comment('所属模型');
            $table->string('data_type', 20)->comment('字段数据类型');
            $table->integer('length' )->unsigned()->comment('字段长度');
            $table->string('form_control', 20)->comment('表单控件');
            $table->string('valid_rule', 100)->comment('验证规则');
            $table->string('valid_msg', 100)->comment('验证提示');
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
        Schema::dropIfExists('model_fields');
    }
};
