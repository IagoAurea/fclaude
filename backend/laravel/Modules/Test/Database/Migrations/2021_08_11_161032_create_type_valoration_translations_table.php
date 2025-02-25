<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeValorationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_valoration_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_valoration_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['type_valoration_id', 'locale']);

            $table->foreign('type_valoration_id')
                ->references('id')
                ->on('type_valorations')  
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
        Schema::dropIfExists('type_valoration_translations');
    }
}
