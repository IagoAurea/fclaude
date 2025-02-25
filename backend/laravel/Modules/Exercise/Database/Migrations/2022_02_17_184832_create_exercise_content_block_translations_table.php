<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseContentBlockTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_content_block_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('exercise_content_block_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['exercise_content_block_id', 'locale']);

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
        Schema::dropIfExists('exercise_content_block_translations');
    }
}
