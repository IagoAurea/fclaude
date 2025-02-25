<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseEducationLevelTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_education_level_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('exercise_education_level_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['exercise_education_level_id', 'locale'], 'exercise_education_level_translations_constraint');

            $table->foreign('exercise_education_level_id')
                ->references('id')
                ->on('exercise_education_levels')
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
        Schema::dropIfExists('exercise_education_level_translations');
    }
}
