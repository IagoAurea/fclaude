<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessQuestionnaireAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wellness_questionnaire_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('wellness_questionnaire_history_id');
            $table->unsignedBigInteger('wellness_questionnaire_answer_item_id');

            $table->foreign('wellness_questionnaire_history_id')
                ->references('id')
                ->on('wellness_questionnaire_history')
                ->onDelete('cascade');

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
        Schema::dropIfExists('wellness_questionnaire_answers');
    }
}
