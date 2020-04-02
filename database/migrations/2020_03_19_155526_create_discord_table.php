<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord', function (Blueprint $table) {
            $table->integer('plus_id')->unique();
            $table->string('server_id');
            $table->enum('status',['ACTIVE','INACTIVE','EXPIRED'])->default('INACTIVE');
            $table->string('def_link',400)->nullable();
            $table->string('ldr_def_link',400)->nullable();
            $table->string('res_link',400)->nullable();
            $table->string('off_link',400)->nullable();
            $table->string('ldr_off_link',400)->nullable();
            $table->string('art_link',400)->nullable();
            $table->string('ww_link',400)->nullable();
            $table->string('ldr_ww_link',400)->nullable();
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
        Schema::dropIfExists('discord');
    }
}
