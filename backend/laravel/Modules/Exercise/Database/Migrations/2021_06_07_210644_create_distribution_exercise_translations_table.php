<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionExerciseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_exercise_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('distribution_exercise_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['distribution_exercise_id', 'locale']);

            $table->foreign('distribution_exercise_id')
                ->references('id')
                ->on('distribution_exercises')
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
        Schema::dropIfExists('distribution_exercise_translations');
    }
}
