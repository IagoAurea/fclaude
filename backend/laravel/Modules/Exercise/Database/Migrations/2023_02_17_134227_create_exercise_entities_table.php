<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_entities', function (Blueprint $table) {
            $table->id();
            $table->morphs('entity');
            $table->unsignedBigInteger('exercise_id');

            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_entities');
    }
}
