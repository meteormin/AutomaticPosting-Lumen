<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefineDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refine_data', function (Blueprint $table) {
            $table->string('code');
            $table->string('name');
            $table->integer('capital');
            $table->integer('roe');
            $table->integer('per');
            $table->integer('pbr');
            $table->integer('current_price');
            $table->integer('netIncome');
            $table->integer('deficit_count');
            $table->float('flow_rate_avg');
            $table->float('debt_rate_avg');
            $table->timestamps();
            $table->primary('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refine_data');
    }
}
