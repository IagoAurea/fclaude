<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jobs_area_id')->nullable();
            $table->string('code');

            $table->foreign('jobs_area_id')
                ->references('id')
                ->on('jobs_area')
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
        Schema::dropIfExists('position_staff');
    }
}
