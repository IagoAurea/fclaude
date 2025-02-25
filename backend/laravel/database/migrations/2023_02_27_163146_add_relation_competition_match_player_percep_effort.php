<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationCompetitionMatchPlayerPercepEffort extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competition_match_players', function (Blueprint $table) {
            $table->foreign('perception_effort_id')
            ->references('id')
            ->on('subjec_percept_efforts')
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
        Schema::table('competition_match_players', function (Blueprint $table) {
            $table->dropForeign('competition_match_players_perception_effort_id_foreign');
        });
    }
}
