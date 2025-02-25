<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryPreventionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_preventions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('detailed_location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_finished')->default(false);
            $table->integer('evaluation_points')->nullable();
            $table->string('profile_status')->default('none');
            $table->string('other_preventive_program_type')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('team_staff_id');
            $table->unsignedInteger('preventive_program_type_id')->nullable();
            $table->unsignedInteger('injury_location_id');
            $table->unsignedInteger('user_id');
            $table->softDeletes();

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('team_staff_id')
                ->references('id')
                ->on('staff_users')
                ->onDelete('cascade');

            $table->foreign('preventive_program_type_id')
                ->references('id')
                ->on('preventive_program_types')
                ->onDelete('cascade');

            $table->foreign('injury_location_id')
                ->references('id')
                ->on('injury_locations')
                ->onDelete('cascade');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('injury_preventions');
    }
}
