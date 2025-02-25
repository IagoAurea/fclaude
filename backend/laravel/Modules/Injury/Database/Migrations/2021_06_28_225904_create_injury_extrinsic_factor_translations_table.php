<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryExtrinsicFactorTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_extrinsic_factor_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('injury_extrinsic_factor_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['injury_extrinsic_factor_id', 'locale'], 'injury_extrinsic_factor_translation');

            $table->foreign('injury_extrinsic_factor_id')
                ->references('id')
                ->on('injury_extrinsic_factors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_extrinsic_factor_translations');
    }
}
