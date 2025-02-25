<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('question_test_id');
            $table->unsignedBigInteger('response_id');
            $table->double('value')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('question_test_id')
                ->references('id')
                ->on('question_tests');   

            $table->foreign('response_id')
                ->references('id')
                ->on('responses') ; 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_responses');
    }
}
