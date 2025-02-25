<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formula_params', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_formula_id');
            $table->string('code');
            $table->string('type')->nullable();
            $table->integer('param')->nullable();
            $table->unsignedBigInteger('question_responses_id')->nullable();
            $table->timestamps();

            $table->foreign('test_formula_id')
                ->references('id')
                ->on('test_formulas');
            
                $table->foreign('question_responses_id')
                ->references('id')
                ->on('question_responses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formula_params');
    }
}
