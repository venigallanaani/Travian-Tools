<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffenseplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offenseplans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('name');
            $table->string('waves')->default(0);
            $table->string('real')->default(0);
            $table->string('fake')->default(0);
            $table->string('other')->default(0);
            $table->string('attackers')->default(0);
            $table->string('targets')->default(0);
            $table->string('status')->nullable();
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullabel();
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
        Schema::dropIfExists('offenseplans');
    }
}
