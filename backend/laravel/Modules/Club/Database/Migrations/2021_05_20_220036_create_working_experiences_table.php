<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('working_experiences')) {
            Schema::create('working_experiences', function (Blueprint $table) {
                $table->id();
                $table->string('club')->nullable();
                $table->string('occupation')->nullable();
                $table->date('start_date')->nullable();
                $table->date('finish_date')->nullable();

                //Foreign Keys
                $table->unsignedBigInteger('staff_id')->nullable();
                $table->foreign('staff_id')
                    ->references('id')
                    ->on('staffs')
                    ->onDelete('cascade');
                

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_experiences');
    }
}
