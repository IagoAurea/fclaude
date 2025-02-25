<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhaseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phase_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phase_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['phase_id', 'locale']);

            $table->foreign('phase_id')
                ->references('id')
                ->on('phases')  
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
        Schema::dropIfExists('phase_translations');
    }
}
