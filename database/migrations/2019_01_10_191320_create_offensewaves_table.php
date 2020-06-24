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
            $table->string('plan_id');
            $table->string('plus_id');
            $table->string('server_id');
            $table->string('a_id');
            $table->integer('a_uid');
            $table->integer('a_x');
            $table->integer('a_y');
            $table->string('a_player');
            $table->string('a_village');
            $table->string('d_id');
            $table->integer('d_uid');
            $table->string('d_player');
            $table->string('d_village');
            $table->integer('d_x');
            $table->integer('d_y');
            $table->integer('waves');
            $table->enum('type',['Real','Fake','Cheif','Scout','Other']);
            $table->string('unit');
            $table->string('starttime')->nullable();
            $table->string('landtime');
            $table->string('comments')->nullable();
            $table->enum('status',['NEW','DRAFT','READY','LAUNCH','SKIP','OTHER'])->default('NEW');
            $table->string('notes')->nullable();
            $table->string('report')->nullable();
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
