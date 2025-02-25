<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatorItemTypesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_item_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calculator_item_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['calculator_item_type_id', 'locale']);

            $table->foreign('calculator_item_type_id')
                ->references('id')
                ->on('calculator_item_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculator_item_type_translations');
    }
}
