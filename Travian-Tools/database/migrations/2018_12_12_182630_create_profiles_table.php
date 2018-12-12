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
            $table->string('uid');
            $table->string('profile');
            $table->string('user_id');
            $table->string('user_name');
            $table->string('server_id');
            $table->string('tribe');
            $table->enum('status',['PRIMARY','DUAL']);
            $table->string('sitter1')->nullable();
            $table->string('sitter2')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
