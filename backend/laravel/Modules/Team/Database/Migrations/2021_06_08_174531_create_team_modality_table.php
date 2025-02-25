<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamModalityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_modality', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('sport_id')->unsigned();

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
        Schema::dropIfExists('team_modality');
    }
}
