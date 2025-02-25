<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('staffs')) {
            Schema::create('staffs', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('position_staff_id')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->date('birth_date')->nullable();
                $table->integer('gender')->nullable();
                $table->string('alias')->nullable();
                $table->text('additional_information')->nullable();
                $table->string('city')->nullable();
                $table->string('zipcode')->nullable();
                $table->string('address')->nullable();
                $table->json('mobile_phone')->nullable();
                
                //Foreign Keys
                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                $table->unsignedBigInteger('study_level_id')->nullable();
                $table->foreign('study_level_id')
                    ->references('id')
                    ->on('study_levels');

                $table->unsignedBigInteger('jobs_area_id')->nullable();
                $table->foreign('jobs_area_id')
                    ->references('id')
                    ->on('jobs_area');

                $table->unsignedBigInteger('image_id')->nullable();
                $table->foreign('image_id')
                    ->references('id')
                    ->on('resources');

                $table->unsignedBigInteger('country_id')->nullable();
                $table->foreign('country_id')
                    ->references('id')
                    ->on('countries');

                $table->unsignedBigInteger('province_id')->nullable();
                $table->foreign('province_id')
                    ->references('id')
                    ->on('provinces');
                
                $table->foreign('position_staff_id')
                    ->references('id')
                    ->on('position_staff');

                $table->softDeletes();
                $table->timestamps();
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
        Schema::dropIfExists('staffs');
    }
}
