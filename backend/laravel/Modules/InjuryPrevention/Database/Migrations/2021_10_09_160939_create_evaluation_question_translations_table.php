<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationQuestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_question_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluation_question_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['evaluation_question_id', 'locale'], 'evaluation_question_translation_cons');

            $table->foreign('evaluation_question_id')
                ->references('id')
                ->on('evaluation_questions')
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
        Schema::dropIfExists('evaluation_question_translations');
    }
}
