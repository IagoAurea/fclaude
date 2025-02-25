<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phase_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->unsignedBigInteger('injury_rfd_id');
            $table->unsignedBigInteger('phase_id');
            $table->unsignedBigInteger('professional_directs_id')->nullable();
            $table->unsignedBigInteger('current_situation_id');
            $table->unsignedBigInteger('sport_id')->nullable();
            $table->boolean('test_passed')->default(false);
            $table->boolean('not_pain')->default(false);
            $table->double('percentage_complete');
            $table->boolean('phase_passed')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('professional_directs_id')
                ->references('id')
                ->on('staff_users');

            $table->foreign('phase_id')
                ->references('id')
                ->on('phases');
            
            $table->foreign('injury_rfd_id')
                ->references('id')
                ->on('injury_rfds');
            
            $table->foreign('current_situation_id')
                ->references('id')
                ->on('current_situations');

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports');

       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phase_details');
    }
}
