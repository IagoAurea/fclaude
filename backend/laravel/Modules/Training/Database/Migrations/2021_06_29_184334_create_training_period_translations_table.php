<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingPeriodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_period_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_period_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['training_period_id', 'locale']);

            $table->foreign('training_period_id')
                ->references('id')
                ->on('training_periods')
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
        Schema::dropIfExists('training_period_translations');
    }
}
