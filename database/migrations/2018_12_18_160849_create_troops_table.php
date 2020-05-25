<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTroopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troops', function (Blueprint $table) {
            $table->string('account_id');
            $table->string('plus_id')->nullable();
            $table->string('server_id');
            $table->string('vid');
            $table->string('village');
            $table->integer('x');
            $table->integer('y');
            $table->integer('unit01')->default(0);      $table->integer('unit02')->default(0);
            $table->integer('unit03')->default(0);      $table->integer('unit04')->default(0);
            $table->integer('unit05')->default(0);      $table->integer('unit06')->default(0);
            $table->integer('unit07')->default(0);      $table->integer('unit08')->default(0);
            $table->integer('unit09')->default(0);      $table->integer('unit10')->default(0);
            $table->integer('upkeep')->default(0);      $table->integer('Tsq')->default(0);
            $table->enum('type',['OFFENSE','DEFENSE','SCOUT','SUPPORT','GHOST','WWH','NONE'])->default('NONE');
            $table->enum('arty',['2','1.5','1','0.67','0.5'])->default('1');
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
        Schema::dropIfExists('troops');
    }
}
