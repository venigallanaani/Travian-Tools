<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->integer('uid');
            $table->string('server_id');
            $table->integer('plus_id');
            $table->integer('rank');
            $table->integer('troops_rank');
            $table->integer('troops_value');
            $table->integer('off_rank');
            $table->integer('off_value');
            $table->integer('def_rank');
            $table->integer('def_value');
            $table->integer('hero_rank');
            $table->integer('hero_value');
            $table->integer('pop_rank');
            $table->integer('pop_value');
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
        Schema::dropIfExists('rankings');
    }
}
