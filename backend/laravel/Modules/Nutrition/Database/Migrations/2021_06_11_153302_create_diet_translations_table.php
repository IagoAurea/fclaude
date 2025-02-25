<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDietTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diet_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diet_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['diet_id', 'locale']);

            $table->foreign('diet_id')
                ->references('id')
                ->on('diets')  
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
        Schema::dropIfExists('diet_translations');
    }
}
