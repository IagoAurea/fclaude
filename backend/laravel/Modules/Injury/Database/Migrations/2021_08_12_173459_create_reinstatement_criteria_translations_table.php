<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReinstatementCriteriaTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reinstatement_criteria_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reinstatement_criteria_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['reinstatement_criteria_id', 'locale']);

            $table->foreign('reinstatement_criteria_id')
                ->references('id')
                ->on('reinstatement_criterias')  
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reinstatement_criteria_translations');
    }
}
