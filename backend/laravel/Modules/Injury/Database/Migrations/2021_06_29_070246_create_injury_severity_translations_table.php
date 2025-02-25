<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjurySeverityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_severity_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('injury_severity_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['injury_severity_id', 'locale'], 'injury_severity_translation');

            $table->foreign('injury_severity_id')
                ->references('id')
                ->on('injury_severities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_severity_translations');
    }
}
