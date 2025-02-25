<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaBodyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_body_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_body_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['area_body_id', 'locale']);

            $table->foreign('area_body_id')
                ->references('id')
                ->on('areas_body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_body_translations');
    }
}
