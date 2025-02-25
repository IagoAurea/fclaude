<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineupPlayerTypesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineup_player_types_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('lineup_player_type_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['lineup_player_type_id', 'locale']);

            $table->foreign('lineup_player_type_id')
                ->references('id')
                ->on('lineup_player_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lineup_player_types_translations');
    }
}
