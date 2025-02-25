<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicalTestTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinical_test_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinical_test_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['clinical_test_type_id', 'locale'], 'clinical_test_type_translation');

            $table->foreign('clinical_test_type_id')
                ->references('id')
                ->on('clinical_test_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinical_test_type_translations');
    }
}
