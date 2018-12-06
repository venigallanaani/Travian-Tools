<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alliances', function (Blueprint $table) {
            $table->string('server_id');
            $table->integer('aid');
            $table->string('alliance')->nullable();
            $table->integer('players')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('villages')->nullable();
            $table->integer('population')->nullable();
            $table->integer('diffpop')->nullable();
            $table->string('table_id')->nullable();
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
        Schema::dropIfExists('alliances');
    }
}
