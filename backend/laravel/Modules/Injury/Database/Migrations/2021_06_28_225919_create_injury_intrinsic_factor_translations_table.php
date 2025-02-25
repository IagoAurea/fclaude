<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryIntrinsicFactorTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_intrinsic_factor_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('injury_intrinsic_factor_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['injury_intrinsic_factor_id', 'locale'], 'injury_intrinsic_factor_translation');

            $table->foreign('injury_intrinsic_factor_id')
                ->references('id')
                ->on('injury_intrinsic_factors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_intrinsic_factor_translations');
    }
}
