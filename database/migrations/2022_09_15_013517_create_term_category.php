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
        Schema::create('sila_term_category', function (Blueprint $table) {
            $table->id();
            $table->integer('object_id')->unsigned()->comment('对象ID');
            $table->integer('category_id')->unsigned()->comment('所属分类ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_category');
    }
};
