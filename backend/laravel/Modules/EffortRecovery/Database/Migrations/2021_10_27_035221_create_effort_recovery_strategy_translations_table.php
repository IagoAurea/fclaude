<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEffortRecoveryStrategyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('effort_recovery_strategy_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('effort_recovery_strategy_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['effort_recovery_strategy_id', 'locale'], 'effort_recovery_strategy_trans');

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
        Schema::dropIfExists('effort_recovery_strategy_translations');
    }
}
