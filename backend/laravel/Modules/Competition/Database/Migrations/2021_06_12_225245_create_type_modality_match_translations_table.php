<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeModalityMatchTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_modality_match_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_modality_match_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['type_modality_match_id', 'locale']);

            $table->foreign('type_modality_match_id')
                ->references('id')
                ->on('type_modalities_match')
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
        Schema::dropIfExists('type_modality_match_translations');
    }
}
