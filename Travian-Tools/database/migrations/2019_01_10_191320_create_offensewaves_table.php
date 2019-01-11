<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffensewavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offensewaves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('planid');
            $table->string('plus_id');
            $table->string('server_id');
            $table->integer('a_uid');
            $table->integer('a_x');
            $table->integer('a_y');
            $table->string('a_player');
            $table->string('a_village');
            $table->integer('d_uid');
            $table->string('d_player');
            $table->string('d_village');
            $table->integer('d_x');
            $table->integer('d_y');
            $table->integer('waves');
            $table->enum('type',['Real','Fake','Cheif','Scout','Other']);
            $table->string('unit');
            $table->string('landtime');
            $table->string('comments');
            $table->string('status');
            $table->string('notes');
            $table->string('report');
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
        Schema::dropIfExists('offensewaves');
    }
}
