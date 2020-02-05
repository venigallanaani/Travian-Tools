<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->string('server_id');
            $table->string('account_id');
            $table->string('vid');
            $table->string('tiles');
            $table->integer('wood');
            $table->integer('clay');
            $table->integer('iron');
            $table->integer('crop');
            $table->integer('prod');
            $table->boolean('cap')->default(FALSE);
            $table->integer('field');
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
        Schema::dropIfExists('villages');
    }
}
