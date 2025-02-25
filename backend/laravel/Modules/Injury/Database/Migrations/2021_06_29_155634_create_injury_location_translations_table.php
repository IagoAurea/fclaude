<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryLocationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_location_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('injury_location_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['injury_location_id', 'locale']);

            $table->foreign('injury_location_id')
                ->references('id')
                ->on('injury_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_location_translations');
    }
}
