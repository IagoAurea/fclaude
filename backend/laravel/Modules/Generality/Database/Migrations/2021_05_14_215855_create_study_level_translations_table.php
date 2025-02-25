<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyLevelTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_level_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_level_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['study_level_id', 'locale']);

            $table->foreign('study_level_id')
                ->references('id')
                ->on('study_levels')
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
        Schema::dropIfExists('study_level_translations');
    }
}
