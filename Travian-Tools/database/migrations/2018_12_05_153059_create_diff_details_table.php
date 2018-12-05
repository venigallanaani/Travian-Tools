<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiffDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diff_details', function (Blueprint $table) {
            $table->string('server_id');
            $table->integer('x');
            $table->integer('y');
            $table->integer('id');
            $table->integer('vid');
            $table->string('village');
            $table->integer('uid');
            $table->string('player');
            $table->integer('aid');
            $table->string('alliance');
            $table->integer('population');
            $table->string('status')->nullable();
            $table->string('table_id')->nullable();
            $table->integer('diffPop')->default('0');
            $table->integer('pop1')->default('0');
            $table->integer('pop2')->default('0');
            $table->integer('pop3')->default('0');
            $table->integer('pop4')->default('0');
            $table->integer('pop5')->default('0');
            $table->integer('pop6')->default('0');
            $table->integer('pop7')->default('0');
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
        Schema::dropIfExists('diff_details');
    }
}
