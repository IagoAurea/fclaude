<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseaseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disease_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['disease_id', 'locale']);

            $table->foreign('disease_id')
                ->references('id')
                ->on('diseases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disease_translations');
    }
}
