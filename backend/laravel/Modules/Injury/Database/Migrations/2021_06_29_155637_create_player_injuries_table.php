<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerInjuriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injuries', function (Blueprint $table) {
            $table->id();
            $table->morphs('entity');
            $table->boolean('is_active')->default(TRUE);

            // 1st part
            $table->timestamp('injury_date');
            $table->integer('injury_day')->default(0);
            $table->unsignedBigInteger('mechanism_injury_id')->nullable();
            $table->unsignedBigInteger('injury_situation_id')->nullable();
            $table->boolean('is_triggered_by_contact')->nullable();

            // 2nd part
            $table->unsignedBigInteger('injury_type_id');
            $table->unsignedBigInteger('injury_type_spec_id');
            $table->text('detailed_diagnose')->nullable();
            $table->unsignedBigInteger('area_body_id');
            $table->text('detailed_location')->nullable();
            $table->unsignedBigInteger('affected_side_id')->nullable(); // Non-relational type
            $table->boolean('is_relapse')->nullable();
            $table->unsignedBigInteger('injury_severity_id')->nullable();
            $table->unsignedBigInteger('injury_location_id')->nullable();

            // 3rd part
            $table->text('injury_forecast')->nullable();
            $table->integer('days_off')->nullable();
            $table->integer('matches_off')->nullable();
            $table->timestamp('medically_discharged_at')->nullable();
            $table->timestamp('sportly_discharged_at')->nullable();
            $table->timestamp('competitively_discharged_at')->nullable();

            // 4th part
            $table->timestamp('surgery_date')->nullable();
            $table->string('surgeon_name')->nullable();
            $table->string('medical_center_name')->nullable();
            $table->text('surgery_extra_info')->nullable();

            // 5th part
            $table->text('extra_info')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mechanism_injury_id')
                ->references('id')
                ->on('mechanisms_injury')
                ->onDelete('cascade');

            $table->foreign('injury_situation_id')
                ->references('id')
                ->on('injury_situations')
                ->onDelete('cascade');

            $table->foreign('injury_type_id')
                ->references('id')
                ->on('injury_types')
                ->onDelete('cascade');

            $table->foreign('injury_type_spec_id')
                ->references('id')
                ->on('injury_type_specs')
                ->onDelete('cascade');

            $table->foreign('area_body_id')
                ->references('id')
                ->on('areas_body')
                ->onDelete('cascade');

            $table->foreign('injury_severity_id')
                ->references('id')
                ->on('injury_severities')
                ->onDelete('cascade');

            $table->foreign('injury_location_id')
                ->references('id')
                ->on('injury_locations')
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
        Schema::dropIfExists('injuries');
    }
}
