<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeExerciseSesionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_exercise_session_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_exercise_session_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['type_exercise_session_id', 'locale']);

            $table->foreign('type_exercise_session_id')
                ->references('id')
                ->on('type_exercise_sessions')
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
        Schema::dropIfExists('type_exercise_session_translations');
    }
}
