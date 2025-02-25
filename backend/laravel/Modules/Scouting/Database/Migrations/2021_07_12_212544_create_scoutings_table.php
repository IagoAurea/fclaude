<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Scouting\Entities\Scouting;

class CreateScoutingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoutings', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('status')->defalut(Scouting::STATUS_NOT_STARTED);
            $table->unsignedBigInteger('competition_match_id');
            $table->enum('start_match', ['L', 'V'])->nullable(); // L = Local | V = Visitant
            $table->json('custom_params')->nullable();
            $table->timestamps();

            $table->foreign('competition_match_id')
                ->references('id')
                ->on('competition_matches')
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
        Schema::dropIfExists('scouting');
    }
}
