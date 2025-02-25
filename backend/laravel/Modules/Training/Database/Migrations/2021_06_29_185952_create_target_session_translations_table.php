<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetSessionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_session_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_session_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['target_session_id', 'locale']);

            $table->foreign('target_session_id')
                ->references('id')
                ->on('target_sessions')
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
        Schema::dropIfExists('target_session_translations');
    }
}
