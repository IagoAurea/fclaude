<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionRivalTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_rival_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_id');
            $table->string('rival_team', 100);
            $table->unsignedBigInteger('image_id')->nullable();

            $table->foreign('competition_id')
                ->references('id')
                ->on('competitions')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources')
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
        Schema::dropIfExists('competition_rival_teams');
    }
}
