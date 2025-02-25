<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatorItemTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calculator_item_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['calculator_item_id', 'locale'], 'calculator_item_translation_cons');

            $table->foreign('calculator_item_id')
                ->references('id')
                ->on('calculator_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculator_item_translations');
    }
}
