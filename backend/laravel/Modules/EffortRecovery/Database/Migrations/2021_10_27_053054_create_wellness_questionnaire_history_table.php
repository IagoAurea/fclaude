<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWellnessQuestionnaireHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wellness_questionnaire_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('effort_recovery_id');
            $table->timestamps();

            $table->foreign('effort_recovery_id')
                ->references('id')
                ->on('effort_recovery')
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
        Schema::dropIfExists('wellness_questionnaire_history');
    }
}
