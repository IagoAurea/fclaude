<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentSituationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_situation_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('current_situation_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['current_situation_id', 'locale']);

            $table->foreign('current_situation_id')
                ->references('id')
                ->on('current_situations')  
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
        Schema::dropIfExists('current_situation_translations');
    }
}
