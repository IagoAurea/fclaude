<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorRubricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicator_rubric', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('indicator_id');
            $table->unsignedInteger('rubric_id');


            $table->foreign('indicator_id')->references('id')->on('evaluation_indicators')->onDelete('cascade');
            $table->foreign('rubric_id')->references('id')->on('evaluation_rubrics')->onDelete('cascade');

            $table->unique(['indicator_id', 'rubric_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicator_rubric');
    }
}
