<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuriesIntrinsicFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injuries_intrinsic_factors', function (Blueprint $table) {
            $table->unsignedBigInteger('injury_id');
            $table->unsignedBigInteger('injury_intrinsic_id');

            $table->foreign('injury_id')
                ->references('id')
                ->on('injuries')
                ->onDelete('cascade');

            $table->foreign('injury_intrinsic_id')
                ->references('id')
                ->on('injury_intrinsic_factors')
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
        Schema::dropIfExists('injuries_intrinsic_factors');
    }
}
