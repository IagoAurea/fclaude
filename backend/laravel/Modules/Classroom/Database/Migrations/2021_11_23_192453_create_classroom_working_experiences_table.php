<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomWorkingExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('classroom_working_experiences')) {
            Schema::create('classroom_working_experiences', function (Blueprint $table) {
                $table->id();
                $table->string('club')->nullable();
                $table->string('occupation')->nullable();
                $table->date('start_date')->nullable();
                $table->date('finish_date')->nullable();

                //Foreign Keys
                $table->unsignedBigInteger('teacher_id')->nullable();
                $table->foreign('teacher_id')
                    ->references('id')
                    ->on('classroom_teachers')
                    ->onDelete('cascade');


                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_working_experiences');
    }
}
