<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->string('server_id')->unique();
            $table->string('url');
            $table->string('country');
            $table->enum('status',['ACTIVE','COMPLETE']);
            $table->date('start_date');
            $table->integer('days');
            $table->string('maps_table');
            $table->string('diff_table');
            $table->string('timezone');
            $table->string('table_id');
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
        Schema::dropIfExists('servers');
    }
}
