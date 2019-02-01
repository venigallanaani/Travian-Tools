<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcetaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resourcetasks', function (Blueprint $table) {
            $table->increments('task_id');
            $table->string('server_id');
            $table->string('plus_id');
            $table->enum('status',['ACTIVE','COMPLETE']);            
            $table->enum('type',['wood','clay','iron','crop','all']);
            $table->integer('res_total');
            $table->integer('x');
            $table->integer('y');
            $table->dateTime('target_time')->nullable();
            $table->string('comments')->nullable();
            $table->integer('res_received')->default(0);
            $table->integer('res_remain')->default(0);
            $table->integer('res_percent')->default(0);
            $table->string('village');
            $table->string('player');
            $table->string('created_by');            
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
        Schema::dropIfExists('resourcetasks');
    }
}
