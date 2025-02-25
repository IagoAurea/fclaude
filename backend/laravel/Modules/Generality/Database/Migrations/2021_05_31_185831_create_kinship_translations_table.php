<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinshipTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinship_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kinship_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['kinship_id', 'locale']);

            $table->foreign('kinship_id')
                ->references('id')
                ->on('kinships')
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
        Schema::dropIfExists('kinship_translations');
    }
}
