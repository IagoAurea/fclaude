<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerTrajectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_trajectories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('club_arrival_type_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();

            $table->foreign('player_id')
                ->references('id')
                ->on('players');

            $table->foreign('club_arrival_type_id')
                ->references('id')
                ->on('club_arrival_types');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_trajectories');
    }
}
