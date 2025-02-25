<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatmentTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treatment_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['treatment_id', 'locale']);

            $table->foreign('treatment_id')
                ->references('id')
                ->on('treatments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatment_translations');
    }
}
