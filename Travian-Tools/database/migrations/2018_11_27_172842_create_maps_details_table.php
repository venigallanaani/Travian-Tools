<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps_details', function (Blueprint $table) {
            $table->string('server_id');
            $table->integer('worldid');
            $table->integer('x');
            $table->integer('y');
            $table->integer('id');
            $table->integer('vid');
            $table->string('village');
            $table->integer('uid');
            $table->string('player');
            $table->integer('aid');
            $table->string('alliance');
            $table->integer('population');
            $table->string('table_id');
            $table->time('updatetime');
            
            $table->foreign('server_id')->references('id')->on('servers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps_details');
    }
}
