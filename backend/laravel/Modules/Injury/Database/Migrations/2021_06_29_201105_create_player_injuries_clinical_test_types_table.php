<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerInjuriesClinicalTestTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_clinical_test_types', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('injury_id');
            $table->unsignedBigInteger('clinical_test_type_id');

            $table->foreign('injury_id')
                ->references('id')
                ->on('injuries')
                ->onDelete('cascade');

            $table->foreign('clinical_test_type_id')
                ->references('id')
                ->on('clinical_test_types')
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
        Schema::dropIfExists('injury_clinical_test_types');
    }
}
