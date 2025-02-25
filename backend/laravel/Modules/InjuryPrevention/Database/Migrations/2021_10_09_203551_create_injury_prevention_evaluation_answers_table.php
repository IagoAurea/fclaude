<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryPreventionEvaluationAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_prevention_evaluation_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('evaluation_question_id');
            $table->unsignedInteger('injury_prevention_id');
            $table->boolean('value')->default(false);

            $table->foreign('evaluation_question_id')
                ->references('id')
                ->on('evaluation_questions')
                ->onDelete('cascade');

            $table->foreign('injury_prevention_id')
                ->references('id')
                ->on('injury_preventions')
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
        Schema::dropIfExists('injury_prevention_evaluation_answers');
    }
}
