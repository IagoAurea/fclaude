<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnsSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumns_sports', function (Blueprint $table) {
            $table->unsignedBigInteger('alumn_id');
            $table->unsignedBigInteger('sport_id');

            $table->foreign('alumn_id')
                ->references('id')
                ->on('alumns')
                ->onDelete('cascade');

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumns_sports');
    }
}
