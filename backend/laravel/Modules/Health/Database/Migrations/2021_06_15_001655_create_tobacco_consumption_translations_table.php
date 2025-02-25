<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTobaccoConsumptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tobacco_consumption_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tobacco_consumption_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['tobacco_consumption_id', 'locale']);

            $table->foreign('tobacco_consumption_id')
                ->references('id')
                ->on('tobacco_consumption');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tobacco_consumption_translations');
    }
}
