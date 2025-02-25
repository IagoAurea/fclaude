<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEffortRecoveryProgramsStrategiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effort_recovery_programs_strategies', function (Blueprint $table) {
            $table->unsignedBigInteger('effort_recovery_id');
            $table->unsignedBigInteger('effort_recovery_strategy_id');

            $table->foreign('effort_recovery_id')
                ->references('id')
                ->on('effort_recovery')
                ->onDelete('cascade');

            $table->foreign('effort_recovery_strategy_id')
                ->references('id')
                ->on('effort_recovery_strategies')
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
        Schema::dropIfExists('effort_recovery_programs_strategies');
    }
}
