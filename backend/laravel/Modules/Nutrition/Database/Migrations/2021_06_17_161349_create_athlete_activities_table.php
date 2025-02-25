<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthleteActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athlete_activities', function (Blueprint $table) {
            $table->id();
            $table->decimal('repose', 4, 2);
            $table->decimal('very_light', 4, 2);
            $table->decimal('light', 4, 2);
            $table->decimal('moderate', 4, 2);
            $table->decimal('intense', 4, 2);
            $table->unsignedBigInteger('nutritional_sheet_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('nutritional_sheet_id')
            ->references('id')
            ->on('nutritional_sheets')
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
        Schema::dropIfExists('athlete_activities');
    }
}
