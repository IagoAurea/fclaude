<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_session_target', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercise_session_id');
            $table->unsignedBigInteger('target_session_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('exercise_session_id')
                ->references('id')
                ->on('exercise_sessions');

            $table->foreign('target_session_id')
                ->references('id')
                ->on('target_sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_session_target');
    }
}
