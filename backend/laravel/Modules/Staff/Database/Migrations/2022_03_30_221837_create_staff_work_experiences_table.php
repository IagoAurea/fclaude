<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('occupation')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->unsignedBigInteger('staff_user_id')->nullable();
            
            $table->foreign('staff_user_id')
                ->references('id')
                ->on('staff_users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_work_experiences');
    }
}
