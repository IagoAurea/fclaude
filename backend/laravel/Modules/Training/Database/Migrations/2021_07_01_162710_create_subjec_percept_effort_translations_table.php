<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjecPerceptEffortTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjec_percept_effort_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subjec_percept_effort_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['subjec_percept_effort_id', 'locale']);

            $table->foreign('subjec_percept_effort_id')
                ->references('id')
                ->on('subjec_percept_efforts')
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
        Schema::dropIfExists('subjec_percept_effort_translations');
    }
}
