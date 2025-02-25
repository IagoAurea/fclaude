<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_academic_years', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('physical_teacher_id')->nullable();
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_text')->nullable();

            $table->foreign('academic_year_id')
                ->references('id')
                ->on('academic_years')
                ->onDelete('cascade');

            $table->foreign('classroom_id')
                ->references('id')
                ->on('classrooms')
                ->onDelete('cascade');

            $table->foreign('physical_teacher_id')
                ->references('id')
                ->on('classroom_teachers')
                ->onDelete('cascade');

            $table->foreign('tutor_id')
                ->references('id')
                ->on('classroom_teachers')
                ->onDelete('cascade');

            $table->foreign('subject_id')
                ->references('id')
                ->on('classroom_subjects')
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
        Schema::dropIfExists('classroom_academic_years');
    }
}
