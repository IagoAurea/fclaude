<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjecPerceptEffortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjec_percept_efforts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('number');
            $table->unsignedBigInteger('image_id')->nullable();

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjec_percept_efforts');
    }
}
