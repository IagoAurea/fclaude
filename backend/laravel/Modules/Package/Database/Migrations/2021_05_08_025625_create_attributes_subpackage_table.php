<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesSubpackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_subpackage', function (Blueprint $table) {
            $table->primary(['subpackage_id','attribute_id']);
            $table->unsignedBigInteger('subpackage_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('quantity')->nullable();
            $table->boolean('available')->default(true);

            $table->foreign('subpackage_id')
                ->references('id')
                ->on('subpackages');
             $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes_pack');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes_subpackage');
    }
}
