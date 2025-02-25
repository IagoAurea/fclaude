<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competition_id');
            $table->dateTime('start_at');
            $table->string('location')->nullable();
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('competition_rival_team_id')->nullable();
            $table->enum('match_situation', ['L', 'V'])->nullable(); // L = Local | V = Visitant
            $table->unsignedBigInteger('referee_id')->nullable();
            $table->unsignedBigInteger('weather_id')->nullable();
            $table->unsignedBigInteger('test_category_id')->nullable();
            $table->unsignedBigInteger('test_type_category_id')->nullable();
            $table->unsignedBigInteger('modality_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('competition_id')
                ->references('id')
                ->on('competitions')
                ->onDelete('cascade');
            $table->foreign('competition_rival_team_id')
                ->references('id')
                ->on('competition_rival_teams')
                ->onDelete('cascade');
            $table->foreign('referee_id')
                ->references('id')
                ->on('referees');
            $table->foreign('weather_id')
                ->references('id')
                ->on('weathers');
            $table->foreign('test_category_id')
                ->references('id')
                ->on('test_categories_match');
            $table->foreign('test_type_category_id')
                ->references('id')
                ->on('test_type_categories_match');
            $table->foreign('modality_id')
                ->references('id')
                ->on('type_modalities_match');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scoutings');
        Schema::dropIfExists('competition_matches');
    }
}
