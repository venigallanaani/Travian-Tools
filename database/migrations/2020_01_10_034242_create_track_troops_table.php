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
            $table->enum('type',['REPORT','TRACK'])->default('TRACK');
            $table->integer('x');
            $table->integer('y');
            $table->integer('vid');
            $table->integer('uid');
            $table->string('player');
            $table->string('alliance');
            $table->string('tribe');
            $table->integer('tsq')->default(0);
            $table->integer('art')->default(4);
            $table->enum('type',['ATTACK','DEFEND','SCOUT','TRACK'])->default('TRACK');
            $table->string('report_date')->nullable();
            $table->string('report')->nullable();
            $table->integer('upkeep')->default(0);
            $table->string('report_data')->nullable();
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
