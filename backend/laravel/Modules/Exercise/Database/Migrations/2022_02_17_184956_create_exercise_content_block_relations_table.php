<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseContentBlockRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_content_block_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('exercise_id')->unsigned();
            $table->unsignedBigInteger('exercise_content_block_id')->unsigned();

            $table->foreign('exercise_id')
                ->references('id')
                ->on('exercises')
                ->onDelete('cascade');

            $table->foreign('exercise_content_block_id')
                ->references('id')
                ->on('exercise_content_blocks')
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
        Schema::dropIfExists('exercise_content_block_relations');
    }
}
