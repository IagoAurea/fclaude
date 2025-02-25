<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qualification_id');
            $table->unsignedBigInteger('qualification_item_id');
            $table->unsignedBigInteger('alumn_id');
            $table->string('result');
            $table->json('competence_score');

            $table->foreign('qualification_id')
                ->references('id')
                ->on('qualifications')
                ->onDelete('cascade');
            
            $table->foreign('qualification_item_id')
                ->references('id')
                ->on('classroom_academic_year_rubric_qualifications')
                ->onDelete('cascade');

            $table->foreign('alumn_id')
                ->references('id')
                ->on('alumns')
                ->onDelete('cascade');

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
        Schema::dropIfExists('qualification_results');
    }
}
