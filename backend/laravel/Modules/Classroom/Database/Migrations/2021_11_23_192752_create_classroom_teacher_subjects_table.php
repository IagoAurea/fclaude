<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomTeacherSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('classroom_id');
            $table->boolean('is_class_tutor')->default(false);
            $table->timestamps();

            $table->foreign('classroom_id')
                ->references('id')
                ->on('classrooms')
                ->onDelete('cascade');
            
            $table->foreign('teacher_id')
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
        Schema::dropIfExists('classroom_teacher_subjects');
    }
}
