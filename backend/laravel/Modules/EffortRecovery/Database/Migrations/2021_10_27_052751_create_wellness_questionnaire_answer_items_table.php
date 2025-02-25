<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessQuestionnaireAnswerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wellness_questionnaire_answer_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('charge');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('wellness_questionnaire_answer_type_id');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('wellness_questionnaire_answer_type_id')
                ->references('id')
                ->on('wellness_questionnaire_answer_types')
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
        Schema::dropIfExists('wellness_questionnaire_answer_items');
    }
}
