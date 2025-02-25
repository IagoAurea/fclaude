<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMechanismInjuryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanism_injury_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mechanism_injury_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['mechanism_injury_id', 'locale']);

            $table->foreign('mechanism_injury_id')
                ->references('id')
                ->on('mechanisms_injury');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mechanism_injury_translations');
    }
}
