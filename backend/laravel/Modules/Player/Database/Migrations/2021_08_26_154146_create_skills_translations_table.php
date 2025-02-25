<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skills_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['skills_id', 'locale']);

            $table->foreign('skills_id')
                ->references('id')
                ->on('skills')
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
        Schema::dropIfExists('skills_translations');
    }
}
