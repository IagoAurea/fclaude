<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcneaeSubtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acneae_subtypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acneae_type_id');
            $table->string('code');
            $table->timestamps();

            $table->foreign('acneae_type_id')
                ->references('id')
                ->on('acneae_types')
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
        Schema::dropIfExists('acneae_subtypes');
    }
}
