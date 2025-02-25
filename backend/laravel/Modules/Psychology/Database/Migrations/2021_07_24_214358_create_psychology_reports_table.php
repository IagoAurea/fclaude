<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsychologyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychology_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->date('date');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->string('staff_name')->nullable();
            $table->unsignedBigInteger('psychology_specialist_id')->nullable();
            $table->text('cause');
            $table->text('anamnesis')->nullable();
            $table->text('presumptive_diagnosis');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('psychology_specialist_id')
                ->references('id')
                ->on('psychology_specialists')
                ->onDelete('cascade');
            
            $table->foreign('staff_id')
                ->references('id')
                ->on('staff_users')
                ->onDelete('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('psychology_reports');
    }
}
