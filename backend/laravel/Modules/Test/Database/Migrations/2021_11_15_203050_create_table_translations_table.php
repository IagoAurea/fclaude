<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description');
            $table->unique(['table_id', 'locale']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('table_id')
                ->references('id')
                ->on('tables') ;   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_translations');
    }
}
