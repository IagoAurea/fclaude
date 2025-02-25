<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessQuestionnaireAnswerItemTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wellness_questionnaire_answer_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wellness_questionnaire_answer_item_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['wellness_questionnaire_answer_item_id', 'locale'], 'wellness_questionnaire_answer_item_trans');

            $table->foreign('wellness_questionnaire_answer_item_id')
                ->references('id')
                ->on('wellness_questionnaire_answer_items')
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
        Schema::dropIfExists('wellness_questionnaire_answer_item_translations');
    }
}
