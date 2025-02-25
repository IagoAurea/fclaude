<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_session_assistances', function (Blueprint $table) {
            $table->id();
            $table->boolean('assistance');
            $table->morphs('applicant');
            $table->unsignedBigInteger('exercise_session_id');
            $table->unsignedBigInteger('perception_effort_id')->nullable();
            $table->string('time_training')->nullable();
            $table->decimal('training_load')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('exercise_session_id')
                ->references('id')
                ->on('exercise_sessions');
            
            $table->foreign('perception_effort_id')
                ->references('id')
                ->on('subjec_percept_efforts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_session_assistances');
    }
}
