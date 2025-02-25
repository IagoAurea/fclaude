<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['test_type_id', 'locale']);

            $table->foreign('test_type_id')
                ->references('id')
                ->on('test_types')  
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
        Schema::dropIfExists('test_type_translations');
    }
}
