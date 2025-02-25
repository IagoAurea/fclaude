<?php

use Modules\Evaluation\Entities\EvaluationResult;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubricEvaluationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubric_evaluation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumn_id');
            $table->unsignedBigInteger('classroom_academic_year_id');
            $table->unsignedBigInteger('evaluation_rubric_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('evaluation_grade')->nullable();
            $table->decimal('qualification_grade')->nullable();
            $table->string('status')->default(EvaluationResult::STATUS_NOT_EVALUATED);

            $table->foreign('alumn_id')->references('id')->on('alumns')->onDelete('cascade');
            $table->foreign('classroom_academic_year_id')->references('id')
                ->on('classroom_academic_years')->onDelete('cascade');
            $table->foreign('evaluation_rubric_id')->references('id')->on('evaluation_rubrics')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubric_evaluation_results');
    }
}
