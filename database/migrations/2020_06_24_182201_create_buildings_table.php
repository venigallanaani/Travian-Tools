<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->integer('level');
            $table->integer('wood');
            $table->integer('clay');
            $table->integer('iron');
            $table->integer('crop');
            $table->integer('all');
            $table->integer('population');
            $table->integer('culture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
