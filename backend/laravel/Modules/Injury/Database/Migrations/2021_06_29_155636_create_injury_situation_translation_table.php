<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjurySituationTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_situation_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('injury_situation_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['injury_situation_id', 'locale'], 'injury_situation_translation');

            $table->foreign('injury_situation_id')
                ->references('id')
                ->on('injury_situations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_situation_translations');
    }
}
