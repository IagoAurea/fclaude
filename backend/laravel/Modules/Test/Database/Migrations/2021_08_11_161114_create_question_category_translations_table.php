<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_category_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['question_category_id', 'locale']);

            $table->foreign('question_category_id')
                ->references('id')
                ->on('question_categories')  
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
        Schema::dropIfExists('question_category_translations');
    }
}
