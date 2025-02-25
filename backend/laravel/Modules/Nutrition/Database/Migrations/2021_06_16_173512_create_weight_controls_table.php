<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeightControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_controls', function (Blueprint $table) {
            $table->id();
            $table->decimal('weight', 10, 2);
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('team_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
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
        Schema::dropIfExists('weight_controls');
    }
}
