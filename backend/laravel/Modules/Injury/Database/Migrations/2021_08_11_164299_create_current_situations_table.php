<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentSituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_situations', function (Blueprint $table) {
            $table->id();
            $table->string('code'); 
            $table->string('color'); 
            $table->double('min_percentage');
            $table->double('max_percentage'); 
            $table->integer('type')->nullable(); //values 1 psychological or 2 phase 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_situations');
    }
}
