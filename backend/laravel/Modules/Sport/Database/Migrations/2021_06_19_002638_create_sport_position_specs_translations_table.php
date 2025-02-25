<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportPositionSpecsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_positions_specs_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sport_position_spec_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['sport_position_spec_id', 'locale']);

            $table->foreign('sport_position_spec_id')
                ->references('id')
                ->on('sports_positions_specs')
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
        Schema::dropIfExists('sports_positions_specs_translations');
    }
}
