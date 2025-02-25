<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEffortAssessmentGpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effort_assessment_gps', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_distance_traveled',4,2)->nullable();
            $table->integer('number_sprints')->nullable();
            $table->decimal('distance_sprint',4,2)->nullable();
            $table->decimal('max_speed',4,2)->nullable();
            $table->integer('metabolic_potency')->nullable();
            $table->decimal('high_speed_race',4,2)->nullable();
            $table->integer('slowdowns')->nullable();
            $table->integer('accelerations')->nullable();
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
        Schema::dropIfExists('effort_assessment_gps');
    }
}
