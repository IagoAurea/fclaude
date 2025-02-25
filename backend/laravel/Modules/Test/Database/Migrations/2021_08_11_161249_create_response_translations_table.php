<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('tooltip')->nullable();
            $table->unique(['response_id', 'locale']);

            $table->foreign('response_id')
                ->references('id')
                ->on('responses')  
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
        Schema::dropIfExists('response_translations');
    }
}
