<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryRfdCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_rfd_criterias', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->unsignedBigInteger('injury_rfd_id');
            $table->unsignedBigInteger('reinstatement_criteria_id');
            $table->boolean('value')->default(false);
            $table->timestamps();

            $table->foreign('injury_rfd_id')
                ->references('id')
                ->on('injury_rfds');
            
            $table->foreign('reinstatement_criteria_id')
                ->references('id')
                ->on('reinstatement_criterias');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_rfd_criterias');
    }
}
