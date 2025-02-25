<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsychologySpecialistTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychology_specialist_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('psychology_specialist_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['psychology_specialist_id', 'locale']);

            $table->foreign('psychology_specialist_id')
                ->references('id')
                ->on('psychology_specialists')
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
        Schema::dropIfExists('psychology_specialist_translations');
    }
}
