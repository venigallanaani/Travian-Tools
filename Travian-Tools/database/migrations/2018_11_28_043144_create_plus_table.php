<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plus', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->string('server_id');
            $table->string('user');
            $table->string('account');
            $table->boolean('plus')->default(TRUE);
            $table->boolean('leader')->default(FALSE);
            $table->boolean('defense')->default(FALSE);
            $table->boolean('offense')->default(FALSE);
            $table->boolean('artifact')->default(FALSE);
            $table->boolean('resources')->default(FALSE);
            $table->boolean('wonder')->default(FALSE);
            $table->timestamps();
            
            $table->foreign('server_id')->references('id')->on('servers');
            $table->foreign('user')->references('name')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plus');
    }
}
