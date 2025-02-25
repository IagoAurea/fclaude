<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatorItemEntityAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_entity_item_answers', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('calculator_entity_answer_historical_record_id');
            $table->foreign('calculator_entity_answer_historical_record_id')
                ->references('id')
                ->on('calculator_entity_answer_historical_records');

            $table->unsignedBigInteger('calculator_entity_item_point_value_id');
            $table->foreign('calculator_entity_item_point_value_id')
                ->references('id')
                ->on('calculator_entity_item_point_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculator_entity_item_answers');
    }
}
