<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hero', function (Blueprint $table) {
            $table->string('account_id');
            $table->string('plus_id')->nullable();
            $table->string('server_id');
            $table->string('vid');
            $table->string('village');
            $table->integer('x');
            $table->integer('y');
            $table->string('name');
            $table->integer('level');
            $table->integer('exp');
            $table->integer('fs');
            $table->integer('off');
            $table->integer('def');
            $table->integer('res');
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
        Schema::dropIfExists('hero');
    }
}
