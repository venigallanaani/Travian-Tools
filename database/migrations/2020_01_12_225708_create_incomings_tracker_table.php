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
            $table->integer('attack')->default(0);
            $table->integer('attack_change')->default(0);
            $table->integer('defense')->default(0);
            $table->integer('defense_change')->default(0);
            $table->integer('exp')->default(0);
            $table->integer('exp_change')->default(0);
            $table->string('image')->nullable();
            $table->enum('image_change',['YES','NO'])->default('NO');
            $table->string('image_old')->nullable();
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
