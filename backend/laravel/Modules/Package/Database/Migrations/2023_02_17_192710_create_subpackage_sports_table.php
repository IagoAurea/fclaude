<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubpackageSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpackage_sports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sport_id');
            $table->unsignedBigInteger('subpackage_id');

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports')
                ->onDelete('cascade');

            $table->foreign('subpackage_id')
                ->references('id')
                ->on('subpackages')
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
        Schema::dropIfExists('subpackage_sports');
    }
}
