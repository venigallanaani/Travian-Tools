<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('account_id');
            $table->string('uid');
            $table->string('account_name');
            $table->string('user_id');
            $table->string('user_name');
            $table->string('server_id');
            $table->string('tribe');
            $table->enum('status',['PRIMARY','DUAL']);
            $table->string('sitter1');
            $table->string('sitter2');
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
        Schema::dropIfExists('accounts');
    }
}
