<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_configurations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('configuration_id');
            $table->unsignedBigInteger('test_id');
            $table->timestamps();

            $table->foreign('configuration_id')
                ->references('id')
                ->on('configurations')  
                ->onDelete('cascade'); 

            $table->foreign('test_id')
                ->references('id')
                ->on('tests')  
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
        Schema::dropIfExists('test_configurations');
    }
}
