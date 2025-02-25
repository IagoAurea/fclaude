<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjurySeverityLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_severity_location', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('severity_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('affected_side_id')->nullable(); // Non-relational type

            $table->foreign('severity_id')
                ->references('id')
                ->on('injury_severities')
                ->onDelete('cascade');
            $table->foreign('location_id')
                ->references('id')
                ->on('injury_locations')
                ->onDelete('cascade');
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
        Schema::dropIfExists('injury_severity_location');
    }
}
