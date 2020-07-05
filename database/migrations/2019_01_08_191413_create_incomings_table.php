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
            $table->increments('id');
            $table->string('incid');
            $table->string('server_id');
            $table->string('plus_id');
            $table->string('uid');
            
            $table->string('att_id');
            $table->string('def_id');
            $table->string('def_uid');
            $table->string('def_player');
            $table->string('def_village');
            $table->string('def_vid');
            $table->string('def_x');
            $table->string('def_y');
            $table->integer('waves');
            $table->enum('type',['Attack','Raid','Other']);
            $table->string('att_uid');
            $table->string('att_player');
            $table->string('att_tribe');
            $table->string('att_village');
            $table->string('att_vid');
            $table->string('att_x');
            $table->string('att_y');
            $table->enum('entry',['MANUAL','AUTO'])->default('AUTO');
            
            $table->string('landTime');
            $table->string('noticeTime');
            
            $table->string('hero_xp')->nullable();
            $table->string('hero_attack')->nullable();
            $table->string('hero_defense')->nullable();
            $table->string('hero_image')->nullable();
            $table->enum('hero_boots',['0','15','20','25']);
            $table->integer('hero_art')->default(4);
            $table->string('comments')->nullable();
            
            $table->enum('status',['DRAFT','SAVED']);
            $table->enum('hero',['No','No Change','Change','Other']);
            $table->string('deleteTime');
            
            $table->enum('scout',['YES','NO'])->default('NO');
            $table->integer('tsq')->default(0);
            $table->integer('unit')->default(3);
            $table->enum('ldr_sts',['NEW','SCOUT','THINKING','DEFEND','ARTEFACT','SNIPE','FAKE','OTHER']);
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
