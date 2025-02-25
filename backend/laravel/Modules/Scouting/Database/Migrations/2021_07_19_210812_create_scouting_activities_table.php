<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoutingActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scouting_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scouting_id')->index();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->unsignedBigInteger('action_id')->unsigned();
            $table->boolean('rival_team_activity')->default(false);
            $table->string('in_game_time');
            $table->boolean('status')->default(true)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('scouting_id')
                ->references('id')
                ->on('scoutings')
                ->onDelete('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
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
        Schema::dropIfExists('scouting_activities');
    }
}
