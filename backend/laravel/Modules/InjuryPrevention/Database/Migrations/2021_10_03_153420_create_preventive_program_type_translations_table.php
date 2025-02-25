<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventiveProgramTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventive_program_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('preventive_program_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['preventive_program_type_id', 'locale'], 'preventive_program_type_translation_cons');

            $table->foreign('preventive_program_type_id')
                ->references('id')
                ->on('preventive_program_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preventive_program_type_translations');
    }
}
