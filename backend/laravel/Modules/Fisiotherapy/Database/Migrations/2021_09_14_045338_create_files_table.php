<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('specialty')->nullable();
            $table->text('anamnesis')->nullable();
            $table->boolean('has_medication')->nullable()->default(false);
            $table->string('medication')->nullable();
            $table->text('medication_objective')->nullable();
            $table->text('observation')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('discharge_date')->nullable();
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('team_staff_id');
            $table->unsignedInteger('injury_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('team_staff_id')
                ->references('id')
                ->on('staff_users')
                ->onDelete('cascade');

            $table->foreign('injury_id')
                ->references('id')
                ->on('injuries')
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
        Schema::dropIfExists('files');
    }
}
