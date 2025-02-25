<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionExerciseWorkGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_session_exercise_work_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercise_session_exercise_id');
            $table->unsignedBigInteger('work_group_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('exercise_session_exercise_id')
                ->references('id')
                ->on('exercise_session_exercises');
                
            $table->foreign('work_group_id')
                ->references('id')
                ->on('work_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_session_exercise_work_group');
    }
}
