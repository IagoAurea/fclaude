<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('percentage');
            $table->string('evaluation_criteria')->nullable();
            $table->string('insufficient_caption')->nullable();
            $table->string('sufficient_caption')->nullable();
            $table->string('remarkable_caption')->nullable();
            $table->string('outstanding_caption')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_indicators');
    }
}
