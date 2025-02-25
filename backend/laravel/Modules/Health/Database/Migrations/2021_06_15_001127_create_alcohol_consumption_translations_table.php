<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlcoholConsumptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alcohol_consumption_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alcohol_consumption_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['alcohol_consumption_id', 'locale']);

            $table->foreign('alcohol_consumption_id')
                ->references('id')
                ->on('alcohol_consumption');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alcohol_consumption_translations');
    }
}
