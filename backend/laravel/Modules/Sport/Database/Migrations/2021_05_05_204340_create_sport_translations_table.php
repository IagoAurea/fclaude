<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('sport_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['sport_id', 'locale']);

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports')
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
        Schema::dropIfExists('sport_translations');
    }
}
