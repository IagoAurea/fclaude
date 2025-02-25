<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributePackTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_pack_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_pack_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['attribute_pack_id', 'locale']);

            $table->foreign('attribute_pack_id')
                ->references('id')
                ->on('attributes_pack')
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
        Schema::dropIfExists('attribute_pack_translations');
    }
}
