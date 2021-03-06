<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->string('server_id');
            $table->integer('uid');
            $table->string('player');
            $table->integer('rank')->nullable();
            $table->string('tribe');
            $table->integer('villages');
            $table->integer('population');
            $table->integer('diffpop');
            $table->integer('aid')->nullable();
            $table->string('alliance')->nullable(); 
            $table->string('table_id');
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
        Schema::dropIfExists('players');
    }
}
