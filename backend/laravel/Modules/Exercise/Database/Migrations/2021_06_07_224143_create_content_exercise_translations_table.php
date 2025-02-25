<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentExerciseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_exercise_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('content_exercise_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['content_exercise_id', 'locale']);

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
        Schema::dropIfExists('content_exercise_translations');
    }
}
