<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('instruction')->nullable();
            $table->text('material')->nullable();
            $table->text('procedure')->nullable();
            $table->text('evaluation')->nullable();
            $table->text('tooltip')->nullable();
            $table->unique(['test_id', 'locale']);

            $table->foreign('test_id')
                ->references('id')
                ->on('tests')
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
        Schema::dropIfExists('test_translations');
    }
}
