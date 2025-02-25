<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineupPlayerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineup_player_types', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('color')->nullable();
            $table->integer('sport_id')->unsigned();

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lineup_player_types');
    }
}
