<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackTroopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackTroops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('att_id');
            $table->integer('x');
            $table->integer('y');
            $table->integer('vid');
            $table->integer('uid');
            $table->string('player');
            $table->string('alliance');
            $table->string('tribe');
            $table->enum('type',['ATTACK','DEFEND','SCOUT'])->default('SCOUT');
            $table->string('report_date');
            $table->string('report');
            $table->integer('upkeep');
            $table->string('report_data');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('trackTroops');
    }
}
