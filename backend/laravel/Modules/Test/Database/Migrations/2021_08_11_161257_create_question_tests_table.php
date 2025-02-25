<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_tests', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('test_id');
            $table->double('value')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')
                ->on('questions');

            $table->foreign('test_id')
                ->references('id')
                ->on('tests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_tests');
    }
}
