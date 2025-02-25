<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Classroom\Entities\ClassroomAcademicYearRubric;

class CreateClassroomRubricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_rubric', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('classroom_academic_year_id');
            $table->unsignedInteger('rubric_id');
            $table->date('evaluation_date')->nullable();
            $table->string('status')->default(ClassroomAcademicYearRubric::STATUS_NOT_EVALUATED);

            $table->foreign('classroom_academic_year_id')->references('id')
                ->on('classroom_academic_years')->onDelete('cascade');
            $table->foreign('rubric_id')->references('id')->on('evaluation_rubrics')->onDelete('cascade');

            $table->unique(['classroom_academic_year_id', 'rubric_id']);
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
        Schema::dropIfExists('classroom_rubric');
    }
}
