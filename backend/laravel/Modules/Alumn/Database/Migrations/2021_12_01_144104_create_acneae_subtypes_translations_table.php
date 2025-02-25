<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcneaeSubtypesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acneae_subtypes_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acneae_subtype_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('tooltip')->nullable();
            $table->unique(['acneae_subtype_id', 'locale']);
            $table->timestamps();

            $table->foreign('acneae_subtype_id')
                ->references('id')
                ->on('acneae_subtypes')
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
        Schema::dropIfExists('acneae_subtypes_translations');
    }
}
