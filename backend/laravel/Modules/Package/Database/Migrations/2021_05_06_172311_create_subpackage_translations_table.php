<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubpackageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpackage_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subpackage_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['subpackage_id', 'locale']);

            $table->foreign('subpackage_id')
                ->references('id')
                ->on('subpackages')
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
        Schema::dropIfExists('subpackage_translations');
    }
}
