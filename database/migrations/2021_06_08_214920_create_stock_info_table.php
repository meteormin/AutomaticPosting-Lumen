<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_info', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('category')->comment('테마: T{theme_code}, 업종: S{sector_code}');
            $table->string('name');
            $table->integer('capital');
            $table->integer('roe');
            $table->integer('per');
            $table->integer('pbr');
            $table->integer('current_price');
            $table->timestamps();
            $table->unique(['code','category']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_info');
    }
}
