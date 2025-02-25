<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplementTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplement_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplement_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['supplement_id', 'locale']);

            $table->foreign('supplement_id')
                ->references('id')
                ->on('supplements')
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
        Schema::dropIfExists('supplement_translations');
    }
}
