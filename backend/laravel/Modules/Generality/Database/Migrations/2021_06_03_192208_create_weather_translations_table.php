<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weather_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['weather_id', 'locale']);

            $table->foreign('weather_id')
                ->references('id')
                ->on('weathers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_translations');
    }
}
