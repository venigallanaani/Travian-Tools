<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceupdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resourceupdates', function (Blueprint $table) {
            $table->integer('task_id');
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('player_id');
            $table->string('player');
            $table->integer('resources')->default(0);
            $table->integer('percent')->default(0);
            $table->timestamps();
            
            $table->foreign('server_id')->references('server_id')->on('servers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resourceupdates');
    }
}
