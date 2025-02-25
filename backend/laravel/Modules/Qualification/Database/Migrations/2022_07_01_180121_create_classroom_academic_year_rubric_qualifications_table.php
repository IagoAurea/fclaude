<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomAcademicYearRubricQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_academic_year_rubric_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qualification_id');
            $table->unsignedBigInteger('rubric_id');
            $table->string('percentage');
            $table->boolean('status')->default(1);

            $table->foreign('qualification_id')
                ->references('id')
                ->on('qualifications')
                ->onDelete('cascade');

            $table->foreign('rubric_id')
                ->references('id')
                ->on('evaluation_rubrics')
                ->onDelete('cascade');

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
        Schema::dropIfExists('classroom_academic_year_rubric_qualifications');
    }
}
