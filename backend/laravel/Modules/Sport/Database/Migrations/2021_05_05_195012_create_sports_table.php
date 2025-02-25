<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->boolean('has_scouting')->default(false);
            $table->smallInteger('time_game')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('image_exercise_id')->nullable();
            $table->unsignedBigInteger('court_id')->nullable();
            $table->string('model_url')->nullable();
            $table->boolean('is_teacher_profile')->default(false);

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('image_exercise_id')
                ->references('id')
                ->on('resources');

            $table->foreign('court_id')
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
        Schema::dropIfExists('sports');
    }
}
