<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraInfoAttributesSubpackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_info_attributes_subpackage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subpackage_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('meta');
            $table->integer('value');
            
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
        Schema::dropIfExists('extra_info_attributes_subpackage');
    }
}
