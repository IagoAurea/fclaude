<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEffortAssessmentHeartRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effort_assessment_heart_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('max_heart_rate')->nullable();
            $table->decimal('mean_heart_rate')->nullable();
            $table->decimal('min_heart_rate')->nullable();
            $table->decimal('variability_heart_rate')->nullable();
            $table->decimal('vo2max')->nullable();
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
        Schema::dropIfExists('effort_assessment_heart_rates');
    }
}
