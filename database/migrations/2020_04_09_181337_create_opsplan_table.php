<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpsplanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opsPlan', function (Blueprint $table) {
            $table->string('item_id');
            $table->string('server_id');
            $table->integer('plus_id');
            $table->integer('ops_id');
            $table->enum('type',['ATTACKER','TARGET','OTHER'])->default('OTHER');
            $table->string('player');
            $table->string('uid');
            $table->string('village');
            $table->string('vid');
            $table->string('x');
            $table->string('y');
            $table->string('tribe');
            $table->string('alliance')->nullable();
            $table->integer('real')->default(0);
            $table->integer('fake')->default(0);
            $table->integer('other')->default(0);
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
        Schema::dropIfExists('opsPlan');
    }
}
