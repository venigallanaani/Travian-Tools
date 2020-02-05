<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingsTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomings_tracker', function (Blueprint $table) {
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('att_id');
            $table->string('helm')->nullable();
            $table->enum('helm_change',['YES','NO'])->default('NO');
            $table->string('chest')->nullable();
            $table->enum('chest_change',['YES','NO'])->default('NO');
            $table->string('boots')->nullable();
            $table->enum('boots_change',['YES','NO'])->default('NO');
            $table->string('left')->nullable();
            $table->enum('left_change',['YES','NO'])->default('NO');
            $table->string('right')->nullable();
            $table->enum('right_change',['YES','NO'])->default('NO');
            $table->integer('attack')->default(0);
            $table->integer('defense')->default(0);
            $table->integer('exp')->default(0);
            $table->enum('hero_change',['YES','NO'])->default('NO');
            $table->string('save_time');
            $table->string('save_by');
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
        Schema::dropIfExists('incomings_tracker');
    }
}
