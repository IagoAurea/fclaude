<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciseTargetSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_target_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('exercise_id')->unsigned();
            $table->unsignedBigInteger('target_session_id')->unsigned();

            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises')
                ->onDelete('cascade');
            $table->foreign('target_session_id')
                ->references('id')
                ->on('target_sessions')
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
        Schema::dropIfExists('exercise_target_sessions');
    }
}
