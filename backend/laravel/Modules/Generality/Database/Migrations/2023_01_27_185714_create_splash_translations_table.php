<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplashTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('splash_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('splash_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description');
            $table->string('text_url')->nullable();
            $table->unique(['splash_id', 'locale']);

            $table->foreign('splash_id')
                ->references('id')
                ->on('splashs')
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
        Schema::dropIfExists('splash_translations');
    }
}
