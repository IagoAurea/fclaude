<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestApplicationAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_application_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_application_id');
            $table->unsignedBigInteger('question_responses_id')->nullable();
            $table->string('text_response')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('question_responses_id')
                ->references('id')
                ->on('question_responses');

            $table->foreign('test_application_id')
                ->references('id')
                ->on('test_applications');

            $table->foreign('unit_id')
                ->references('id')
                ->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_application_answers');
    }
}
