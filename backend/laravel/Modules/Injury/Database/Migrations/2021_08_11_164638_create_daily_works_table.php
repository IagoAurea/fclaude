<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_works', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->date('day');
            $table->string('duration',5);
            $table->integer('rpe')->nullable();
            $table->boolean('control_test')->default(false);
            $table->integer('training_load')->nullable();
            $table->double('monotony')->nullable();
            $table->double('training_strain')->nullable();
            $table->mediumText('test')->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('injury_rfd_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('injury_rfd_id')
                ->references('id')
                ->on('injury_rfds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_works');
    }
}
