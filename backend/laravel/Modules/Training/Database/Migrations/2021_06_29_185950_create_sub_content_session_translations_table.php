<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubContentSessionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_content_session_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_content_session_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['sub_content_session_id', 'locale']);

            $table->foreign('sub_content_session_id')
                ->references('id')
                ->on('sub_content_sessions')
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
        Schema::dropIfExists('sub_content_session_translations');
    }
}
