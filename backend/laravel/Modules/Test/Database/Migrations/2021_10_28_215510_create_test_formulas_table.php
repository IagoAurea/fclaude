<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_formulas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formula_id');
            $table->unsignedBigInteger('test_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('test_id')
                ->references('id')
                ->on('tests');
            
            $table->foreign('formula_id')
                ->references('id')
                ->on('formulas')  
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
        Schema::dropIfExists('test_formulas');
    }
}
