<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('tribe');
            $table->string('tribe_id');
            $table->string('name');
            $table->string('type');
            $table->string('upkeep');
            $table->string('carry');
            $table->string('speed');
            $table->string('offense');
            $table->string('offense_max');
            $table->string('defense_inf');
            $table->string('defense_inf_max');
            $table->string('defense_cav');
            $table->string('defense_cav_max');
            $table->string('cost');
            $table->string('cost_wood');
            $table->string('cost_clay');
            $table->string('cost_iron');
            $table->string('cost_crop');
            $table->string('time');
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
