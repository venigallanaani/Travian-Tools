<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('server_id');
            $table->string('owner');
            $table->integer('duration');
            $table->enum('status',['INPROCESS','ACTIVE','EXPIRED']);
            $table->string('link')->nullable();
            $table->date('end_date');
            $table->string('timezone')->nullable();
            $table->string('message')->nullable();
            $table->string('message_update')->nullable();
            $table->string('message_date')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
