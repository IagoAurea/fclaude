<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamModalityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_modality_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('team_modality_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['team_modality_id', 'locale']);

            $table->foreign('team_modality_id')
                ->references('id')
                ->on('team_modality')
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
        Schema::dropIfExists('team_modality_translations');
    }
}
