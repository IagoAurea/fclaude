<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });

        Schema::create('classroom_subject_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['subject_id', 'locale']);

            $table->foreign('subject_id')
                ->references('id')
                ->on('classroom_subjects')
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
        Schema::dropIfExists('classroom_subject_translations');
        Schema::dropIfExists('classroom_subjects');
    }
}
