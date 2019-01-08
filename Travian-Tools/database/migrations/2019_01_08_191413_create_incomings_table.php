<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomings', function (Blueprint $table) {
            $table->string('incid');
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('uid');
            
            $table->string('def_player');
            $table->string('def_village');
            $table->string('def_x');
            $table->string('def_y');
            $table->integer('waves');
            $table->enum('type',['Attack','Raid','Other']);
            $table->string('att_uid');
            $table->string('att_player');
            $table->string('att_tribe');
            $table->string('att_village');
            $table->string('att_x');
            $table->string('att_y');
            $table->string('landTime');
            $table->string('noticeTime');
            $table->integer('hero_xp')->nullable();
            $table->string('hero_helm')->nullable();
            $table->string('hero_chest')->nullable();
            $table->string('hero_boots')->nullable();
            $table->string('hero_right')->nullable();
            $table->string('hero_left')->nullable();
            $table->string('comments')->nullable();
            
            $table->enum('status',['DRAFT','SAVED']);
            $table->enum('hero',['No','No Change','Change','Other']);
            $table->string('deleteTime');
            
            $table->integer('tsq')->default(0);
            $table->enum('ldr_sts',['New','Mark','Attack','Fake','Thinking','Other']);
            $table->string('ldr_nts')->nullable();
            $table->string('updated_by')->nullable();
            
            
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
        Schema::dropIfExists('incomings');
    }
}
