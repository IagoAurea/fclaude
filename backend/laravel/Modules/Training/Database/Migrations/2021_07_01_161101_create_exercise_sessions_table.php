<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->string('author');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->integer('difficulty')->nullable();
            $table->integer('intensity')->nullable();
            $table->string('duration',6);
            $table->integer('number_exercises')->nullable();
            $table->string('materials')->nullable();
            $table->unsignedBigInteger('type_exercise_session_id')->nullable();
            $table->unsignedBigInteger('training_period_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->morphs('entity');
            $table->integer('order')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('type_exercise_session_id')
                ->references('id')
                ->on('type_exercise_sessions')
                ->onDelete('cascade');

            $table->foreign('training_period_id')
                ->references('id')
                ->on('training_periods')
                ->onDelete('cascade');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('exercise_sessions');
    }
}
