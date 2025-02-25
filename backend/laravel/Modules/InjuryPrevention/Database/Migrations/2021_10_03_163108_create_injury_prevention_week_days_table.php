<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryPreventionWeekDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_prevention_week_days', function (Blueprint $table) {
            $table->unsignedInteger('injury_prevention_id');
            $table->foreign('injury_prevention_id')
                ->references('id')
                ->on('injury_preventions')
                ->onDelete('cascade');

            $table->unsignedInteger('week_day_id');
            $table->foreign('week_day_id')
                ->references('id')
                ->on('week_days')
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
        Schema::dropIfExists('injury_prevention_week_days');
    }
}
