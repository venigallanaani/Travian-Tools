<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->string('id');
            $table->string('type');
            $table->string('subject')->nullable();
            $table->string('tribe')->nullable();
            $table->string('stat1')->nullable();
            $table->string('stat2')->nullable();
            $table->string('stat3')->nullable();
            $table->text('info')->nullable();
            $table->string('deldate')->nullable;
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
        Schema::dropIfExists('reports');
    }
}
