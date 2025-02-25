<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllergyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergy_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allergy_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['allergy_id', 'locale']);

            $table->foreign('allergy_id')
                ->references('id')
                ->on('allergies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergy_translations');
    }
}
