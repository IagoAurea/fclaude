<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatorEntityItemPointValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_entity_item_point_values', function (Blueprint $table) {
            $table->id();

            $table->string('condition')->nullable();
            $table->string('title')->nullable();
            $table->integer('points');

            $table->unsignedBigInteger('calculator_item_id');
            $table->foreign('calculator_item_id')
                ->references('id')
                ->on('calculator_items');

            $table->unsignedBigInteger('calculator_item_type_id');
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
        Schema::dropIfExists('calculator_entity_item_point_values');
    }
}
