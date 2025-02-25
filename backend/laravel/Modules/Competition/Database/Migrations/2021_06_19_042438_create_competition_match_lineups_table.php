<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionMatchLineupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_match_lineups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_match_id');
            $table->unsignedBigInteger('type_lineup_id');

            $table->foreign('competition_match_id')
                ->references('id')
                ->on('competition_matches')
                ->onDelete('cascade');

            $table->foreign('type_lineup_id')
                ->references('id')
                ->on('type_lineups')
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
        Schema::dropIfExists('competition_match_lineups');
    }
}
