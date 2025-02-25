<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('injury_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['injury_type_id', 'locale'], 'injury_type_translation');

            $table->foreign('injury_type_id')
                ->references('id')
                ->on('injury_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_type_translations');
    }
}
