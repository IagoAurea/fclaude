<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingLoadsExerciseSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_loads_exercise_session', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_load_id');
            $table->unsignedBigInteger('exercise_session_assistance_id');
            $table->timestamps();

            $table->foreign('training_load_id')
                ->references('id')
                ->on('training_loads');

            $table->foreign('exercise_session_assistance_id')
                ->references('id')
                ->on('exercise_session_assistances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_loads_exercise_session');
    }
}
