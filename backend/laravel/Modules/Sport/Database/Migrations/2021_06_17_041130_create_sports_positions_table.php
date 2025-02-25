<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_positions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('sport_id');

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
        Schema::dropIfExists('sports_positions_specs');
        Schema::dropIfExists('sports_positions');
    }
}
