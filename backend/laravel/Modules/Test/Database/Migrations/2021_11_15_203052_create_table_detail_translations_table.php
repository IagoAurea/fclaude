<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_detail_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_detail_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description');
            $table->unique(['table_detail_id', 'locale']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('table_detail_id')
                ->references('id')
                ->on('table_details')  
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
        Schema::dropIfExists('table_detail_translations');
    }
}
