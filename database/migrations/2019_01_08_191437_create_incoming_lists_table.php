<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomingLists', function (Blueprint $table) {
            
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('uid');
            $table->string('player');
            $table->string('village');
            $table->integer('tsq')->default(0);
            $table->string('comments');
            
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
        Schema::dropIfExists('incomingLists');
    }
}
