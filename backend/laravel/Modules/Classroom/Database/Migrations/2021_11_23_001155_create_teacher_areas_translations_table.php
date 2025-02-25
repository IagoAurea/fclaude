<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherAreasTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_areas_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_area_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['teacher_area_id', 'locale']);

            $table->foreign('teacher_area_id')
                ->references('id')
                ->on('teacher_areas')
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
        Schema::dropIfExists('teacher_areas_translations');
    }
}
