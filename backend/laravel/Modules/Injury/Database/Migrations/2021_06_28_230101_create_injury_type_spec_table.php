<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryTypeSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_type_specs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('injury_type_id');
            $table->unsignedBigInteger('image_id')->nullable();

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('injury_type_id')
                ->references('id')
                ->on('injury_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('injury_type_specs');
    }
}
