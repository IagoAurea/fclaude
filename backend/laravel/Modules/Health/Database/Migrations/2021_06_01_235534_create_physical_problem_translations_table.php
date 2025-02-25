<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhysicalProblemTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_problem_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('physical_problem_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['physical_problem_id', 'locale']);

            $table->foreign('physical_problem_id')
                ->references('id')
                ->on('physical_problems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physical_problem_translations');
    }
}
