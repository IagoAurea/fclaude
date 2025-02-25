<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_contracts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('player_id');
            $table->string('title')->nullable();
            $table->integer('year_duration');
            $table->timestamp('contract_creation');
            $table->unsignedBigInteger('image_id')->nullable();

            $table->foreign('player_id')
                ->references('id')
                ->on('players');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_contracts');
    }
}
