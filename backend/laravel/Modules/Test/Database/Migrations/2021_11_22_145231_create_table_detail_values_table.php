<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_detail_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_detail_id');
            $table->string('value');
            $table->integer('order');
            $table->unique(['table_detail_id', 'order']);
            $table->timestamps();

            $table->foreign('table_detail_id')
                ->references('id')
                ->on('table_details')  
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
        Schema::dropIfExists('table_detail_values');
    }
}
