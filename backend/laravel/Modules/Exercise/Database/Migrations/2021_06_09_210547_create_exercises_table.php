<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('favorite')->default(false);
            $table->string('dimentions')->nullable();
            $table->string('duration', 5)->nullable();
            $table->integer('repetitions')->nullable();
            $table->string('duration_repetitions', 5)->nullable();
            $table->string('break_repetitions', 5)->nullable();
            $table->integer('series')->nullable();
            $table->string('break_series', 5)->nullable();
            $table->integer('difficulty')->nullable();
            $table->integer('intensity')->nullable();
            $table->text('thumbnail')->nullable();
            $table->json('3d')->nullable();
            $table->unsignedBigInteger('distribution_exercise_id')->nullable();
            $table->unsignedBigInteger('exercise_education_level_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sport_id')->nullable();
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('distribution_exercise_id')
                ->references('id')
                ->on('distribution_exercises');

            $table->foreign('exercise_education_level_id')
                ->references('id')
                ->on('exercise_education_levels')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports');

            $table->foreign('resource_id')
                ->references('id')
                ->on('resources');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
    }
}
