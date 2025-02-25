<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubricEvaluationGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubric_evaluation_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumn_id');
            $table->unsignedBigInteger('classroom_academic_year_id');
            $table->unsignedBigInteger('indicator_rubric_id');
            $table->integer('grade');

            $table->foreign('alumn_id')->references('id')->on('alumns')->onDelete('cascade');
            $table->foreign('classroom_academic_year_id')->references('id')
                ->on('classroom_academic_years')->onDelete('cascade');
            $table->foreign('indicator_rubric_id')->references('id')->on('indicator_rubric')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('rubric_evaluation_grades');
    }
}
