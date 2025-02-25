<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('image_id')->nullable();

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
        Schema::dropIfExists('injury_locations');
    }
}
