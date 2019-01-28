<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefenseUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defenseUpdates', function (Blueprint $table) {
            $table->string('task_id');
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('player_id');
            $table->string('player');
            $table->string('vid');
            $table->string('village');
            $table->integer('resources')->default(0);
            $table->string('tribe_id');
            $table->integer('unit01');
            $table->integer('unit02');
            $table->integer('unit03');
            $table->integer('unit04');
            $table->integer('unit05');
            $table->integer('unit06');
            $table->integer('unit07');
            $table->integer('unit08');
            $table->integer('unit09');
            $table->integer('unit10');
            $table->integer('upkeep');
            $table->integer('def_inf');
            $table->integer('def_cav');
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
        Schema::dropIfExists('defenseUpdates');
    }
}
