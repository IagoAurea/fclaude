<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionMatchRivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_match_rivals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_match_id');
            $table->string('rival_player', 255);
            $table->timestamps();

            $table->foreign('competition_match_id')
                ->references('id')
                ->on('competition_matches')
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
        Schema::dropIfExists('competition_match_rivals');
    }
}
