<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeLineupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_lineups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sport_id');
            $table->unsignedBigInteger('modality_id')->nullable();
            $table->string('lineup');
            $table->integer('total_players');
            $table->timestamps();

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports')
                ->onDelete('cascade');

            $table->foreign('modality_id')
                ->references('id')
                ->on('team_modality')
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
        Schema::dropIfExists('type_lineups');
    }
}
