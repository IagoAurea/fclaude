<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionMatchPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_match_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_match_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('lineup_player_type_id')->nullable();
            $table->unsignedBigInteger('perception_effort_id')->nullable();
            $table->integer('order')->nullable();

            $table->foreign('competition_match_id')
                ->references('id')
                ->on('competition_matches')
                ->onDelete('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('lineup_player_type_id')
                ->references('id')
                ->on('lineup_player_types')
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
        Schema::dropIfExists('competition_match_players');
    }
}
