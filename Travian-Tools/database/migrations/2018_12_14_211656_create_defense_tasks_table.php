<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefenseTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defensetasks', function (Blueprint $table) {
            $table->increments('task_id');
            $table->string('server_id');
            $table->string('plus_id');
            $table->enum('status',['ACTIVE','COMPLETE']);
            $table->enum('type',['defend','snipe','stand','scout','other']);
            $table->enum('priority',['high','medium','low','none']);
            $table->integer('def_total');
            $table->boolean('crop')->default(FALSE);
            $table->integer('x');
            $table->integer('y');
            $table->dateTime('target_time')->nullable();
            $table->string('comments')->nullable();
            $table->string('village');
            $table->string('player');
            $table->string('created_by');
            $table->string('updated_by')->nullable(); 
            $table->integer('def_received')->default(0);
            $table->integer('def_remain')->default(0);
            $table->integer('def_percent')->default(0);
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
        Schema::dropIfExists('defensetasks');
    }
}
