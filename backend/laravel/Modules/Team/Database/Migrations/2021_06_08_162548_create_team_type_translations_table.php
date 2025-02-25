<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_type_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('team_type_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['team_type_id', 'locale']);

            $table->foreign('team_type_id')
                ->references('id')
                ->on('team_type')
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
        Schema::dropIfExists('team_type_translations');
    }
}
