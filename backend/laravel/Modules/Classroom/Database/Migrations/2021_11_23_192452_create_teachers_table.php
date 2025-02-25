<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id')->nullable();
            $table->unsignedBigInteger('teacher_area_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('cover_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('gender_id')->nullable();
            $table->string('username')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('responsibility')->nullable();
            $table->string('additional_information')->nullable();
            $table->unsignedBigInteger('position_staff_id')->nullable();
            $table->unsignedBigInteger('study_level_id')->nullable();
            $table->boolean('department_chief')->nullable();
            $table->boolean('class_tutor')->nullable();
            $table->integer('total_courses')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('cover_id')
                ->references('id')
                ->on('resources');

            $table->foreign('teacher_area_id')
                ->references('id')
                ->on('teacher_areas');

            $table->foreign('study_level_id')
                ->references('id')
                ->on('study_levels');

            $table->foreign('position_staff_id')
                ->references('id')
                ->on('position_staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_teachers');
    }
}
