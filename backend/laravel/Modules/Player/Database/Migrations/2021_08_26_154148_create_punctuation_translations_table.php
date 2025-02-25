<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePunctuationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punctuation_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('punctuation_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['punctuation_id', 'locale']);

            $table->foreign('punctuation_id')
                ->references('id')
                ->on('punctuations')
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
        Schema::dropIfExists('punctuation_translations');
    }
}
