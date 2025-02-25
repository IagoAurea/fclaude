<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeCompetitionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_competition_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_competition_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['type_competition_id', 'locale']);

            $table->foreign('type_competition_id')
                ->references('id')
                ->on('type_competitions')
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
        Schema::dropIfExists('type_competition_translations');
    }
}
