<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAreaTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_area_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_area_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['job_area_id', 'locale']);

            $table->foreign('job_area_id')
                ->references('id')
                ->on('jobs_area')
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
        Schema::dropIfExists('job_area_translations');
    }
}
