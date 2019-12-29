<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtifactsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifactsList', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('size');
            $table->string('lvl');
            $table->string('grp');
            $table->string('tc');
            $table->string('description');            
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
        Schema::dropIfExists('artifactsList');
    }
}
