<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sub_types', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('test_type_id');
            $table->unsignedBigInteger('image_id')->nullable();

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('test_type_id')
                ->references('id')
                ->on('test_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_sub_types');
    }
}
