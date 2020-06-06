<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('raid',[1,0])->default(0);
            $table->string('skype')->nullable();
            $table->string('discord')->nullable();
            $table->string('phone')->nullable();
            $table->string('dateformat')->default('Y-m-d H:i:s');
            $table->string('dateformatLong')->default('YYYY-MM-DD HH:mm:ss');
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
        Schema::dropIfExists('profiles');
    }
}
