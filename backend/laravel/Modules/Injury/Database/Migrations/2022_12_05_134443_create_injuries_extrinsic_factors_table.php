<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuriesExtrinsicFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injuries_extrinsic_factors', function (Blueprint $table) {
            $table->unsignedBigInteger('injury_id');
            $table->unsignedBigInteger('injury_extrinsic_id');

            $table->foreign('injury_id')
                ->references('id')
                ->on('injuries')
                ->onDelete('cascade');

            $table->foreign('injury_extrinsic_id')
                ->references('id')
                ->on('injury_extrinsic_factors')
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
        Schema::dropIfExists('injuries_extrinsic_factors');
    }
}
