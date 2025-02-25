<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_package', function (Blueprint $table) {
            $table->primary(['package_id','attribute_id']);
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('attribute_id');

            $table->foreign('package_id')
                ->references('id')
                ->on('packages');
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
        Schema::dropIfExists('attributes_package');
    }
}
