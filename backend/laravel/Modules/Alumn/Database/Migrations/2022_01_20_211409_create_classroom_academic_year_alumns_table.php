<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomAcademicYearAlumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_academic_year_alumns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classroom_academic_year_id');
            $table->unsignedBigInteger('alumn_id');

            $table->foreign('classroom_academic_year_id')
                ->references('id')
                ->on('classroom_academic_years')
                ->onDelete('cascade');

            $table->foreign('alumn_id')
                ->references('id')
                ->on('alumns')
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
        Schema::dropIfExists('classroom_academic_year_alumns');
    }
}
