<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionEffortAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_session_effort_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistance_id')->unique();
            $table->unsignedBigInteger('subjec_percept_effort_id');
            $table->unsignedBigInteger('effort_assessment_heart_rate_id');
            $table->unsignedBigInteger('effort_assessment_gps_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('assistance_id')
                ->references('id')
                ->on('exercise_session_assistances');

            $table->foreign('subjec_percept_effort_id')
                ->references('id')
                ->on('subjec_percept_efforts');

            $table->foreign('effort_assessment_heart_rate_id')
                ->references('id')
                ->on('effort_assessment_heart_rates');

            $table->foreign('effort_assessment_gps_id')
                ->references('id')
                ->on('effort_assessment_gps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_session_effort_assessments');
    }
}
