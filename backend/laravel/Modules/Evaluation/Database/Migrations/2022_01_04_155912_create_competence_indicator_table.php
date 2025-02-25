<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenceIndicatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competence_indicator', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('competence_id');
            $table->unsignedInteger('indicator_id');


            $table->foreign('competence_id')->references('id')->on('evaluation_competences')->onDelete('cascade');
            $table->foreign('indicator_id')->references('id')->on('evaluation_indicators')->onDelete('cascade');

            $table->unique(['competence_id', 'indicator_id']);
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
        Schema::dropIfExists('competence_indicator');
    }
}
