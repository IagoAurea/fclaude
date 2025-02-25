<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportPositionSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_positions_specs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('sport_position_id');

            $table->foreign('sport_position_id')
                ->references('id')
                ->on('sports_positions')
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
        Schema::dropIfExists('sport_position_specs');
    }
}
