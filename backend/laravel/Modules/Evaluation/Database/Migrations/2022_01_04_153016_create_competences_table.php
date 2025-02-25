<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_competences', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->timestamps();
        });

        Schema::create('evaluation_competences_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_competence_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('acronym');

            $table->unique(['evaluation_competence_id', 'locale']);
            $table->foreign('evaluation_competence_id')->references('id')->on('evaluation_competences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_competences_translations');
        Schema::dropIfExists('evaluation_competences');
    }
}
