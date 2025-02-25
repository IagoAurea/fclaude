<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoutingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scouting_results', function (Blueprint $table) {
            $table->id();
            $table->json('data')->nullable();
            $table->unsignedBigInteger('scouting_id');
            $table->string('in_game_time')->nullable();
            $table->boolean('use_tool')->default(FALSE);
            $table->timestamps();

            $table->foreign('scouting_id')
                ->references('id')
                ->on('scoutings')
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
        Schema::dropIfExists('scouting_results');
    }
}
