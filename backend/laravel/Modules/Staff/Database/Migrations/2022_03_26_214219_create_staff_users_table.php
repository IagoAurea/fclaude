<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email');
            $table->string('username')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->morphs('entity');
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('study_level_id')->nullable();
            $table->unsignedBigInteger('jobs_area_id')->nullable();
            $table->unsignedBigInteger('position_staff_id')->nullable();
            $table->string('responsibility')->nullable();
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('study_level_id')
                ->references('id')
                ->on('study_levels')
                ->onDelete('cascade');

            $table->foreign('jobs_area_id')
                ->references('id')
                ->on('jobs_area')
                ->onDelete('cascade');

            $table->foreign('position_staff_id')
                ->references('id')
                ->on('position_staff')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_users');
    }
}
