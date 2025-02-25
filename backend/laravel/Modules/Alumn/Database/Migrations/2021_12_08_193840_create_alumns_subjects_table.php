<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnsSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumns_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('alumn_id');
            $table->unsignedBigInteger('subject_id');

            $table->foreign('alumn_id')
                ->references('id')
                ->on('alumns')
                ->onDelete('cascade');

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
        Schema::dropIfExists('alumns_subjects');
    }
}
