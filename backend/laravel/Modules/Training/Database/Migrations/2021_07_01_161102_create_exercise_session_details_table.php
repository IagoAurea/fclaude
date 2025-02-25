<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_session_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercise_session_id');
            $table->unsignedBigInteger('exercise_session_place_id');
            $table->date('date_session');
            $table->string('hour_session', 5);
            $table->string('observation')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('exercise_session_id')
                ->references('id')
                ->on('exercise_sessions');

            $table->foreign('exercise_session_place_id')
                ->references('id')
                ->on('exercise_session_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_session_details');
    }
}
