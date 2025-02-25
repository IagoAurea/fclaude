<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('question_category_code')->nullable();
            $table->string('field_type')->default('alphanumber');
            $table->boolean('is_configuration_question')->default(false);
            $table->boolean('required')->default(true);
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->integer('configuration_question_index')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('question_category_code')
            //     ->nullable()
            //     ->references('code')
            //     ->on('question_categories');
            
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
        Schema::dropIfExists('questions');
    }
}
