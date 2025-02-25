<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCategoryMatchTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_category_match_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_category_match_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['test_category_match_id', 'locale']);

            $table->foreign('test_category_match_id')
                ->references('id')
                ->on('test_categories_match')
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
        Schema::dropIfExists('test_category_match_translations');
    }
}
