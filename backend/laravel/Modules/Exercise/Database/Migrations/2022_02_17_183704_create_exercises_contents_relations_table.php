<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesContentsRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises_contents_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('exercise_id')->unsigned();
            $table->unsignedBigInteger('content_exercise_id')->unsigned();

            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises')
                ->onDelete('cascade');

            $table->foreign('content_exercise_id')
                ->references('id')
                ->on('contents_exercise')
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
        Schema::dropIfExists('exercises_contents_relations');
    }
}
