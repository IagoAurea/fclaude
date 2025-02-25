<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolCenterTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_center_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_center_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['school_center_type_id', 'locale']);

            $table->foreign('school_center_type_id')
                ->references('id')
                ->on('school_center_types')
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
        Schema::dropIfExists('school_center_type_translations');
    }
}
