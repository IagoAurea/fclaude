<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_session_exercises', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->string('duration', 5);
            $table->integer('repetitions')->nullable();
            $table->string('duration_repetitions',5)->nullable();
            $table->string('break_repetitions',5)->nullable();
            $table->integer('series')->nullable();
            $table->string('break_series',5)->nullable();
            $table->integer('difficulty')->nullable();
            $table->integer('intensity')->nullable();
            $table->integer('order')->nullable();
            $table->unsignedBigInteger('exercise_session_id');
            $table->unsignedBigInteger('exercise_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('exercise_session_id')
                ->references('id')
                ->on('exercise_sessions')
                ->onDelete('cascade');

            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises')
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
        Schema::dropIfExists('exercise_session_exercises');
    }
}
