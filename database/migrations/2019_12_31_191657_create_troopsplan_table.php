<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTroopsplanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troopsplan', function (Blueprint $table) {
            $table->string('server_id');
            $table->string('account_id');
            $table->string('vid');
            $table->string('village');
            $table->string('plan_name')->nullable();
            $table->string('comments')->nullable();
            $table->string('tribe');
            $table->integer('unit_01')->default(0);
            $table->integer('unit_02')->default(0);
            $table->integer('unit_03')->default(0);
            $table->integer('unit_04')->default(0);
            $table->integer('unit_05')->default(0);
            $table->integer('unit_06')->default(0);
            $table->integer('unit_07')->default(0);
            $table->integer('unit_08')->default(0);
            $table->integer('unit_09')->default(0);
            $table->integer('unit_10')->default(0);
            $table->integer('unit_upkeep')->default(0);
            $table->integer('p_unit_01')->default(0);
            $table->integer('p_unit_02')->default(0);
            $table->integer('p_unit_03')->default(0);
            $table->integer('p_unit_04')->default(0);
            $table->integer('p_unit_05')->default(0);
            $table->integer('p_unit_06')->default(0);
            $table->integer('p_unit_07')->default(0);
            $table->integer('p_unit_08')->default(0);
            $table->integer('p_unit_09')->default(0);
            $table->integer('p_unit_10')->default(0);
            $table->integer('p_unit_upkeep')->default(0);
            $table->string('create_date')->nullable();
            $table->string('update_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('troopsplan');
    }
}
