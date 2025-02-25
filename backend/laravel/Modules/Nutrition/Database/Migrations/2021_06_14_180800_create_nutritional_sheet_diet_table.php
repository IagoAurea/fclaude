<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionalSheetDietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritional_sheet_diet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diet_id');
            $table->unsignedBigInteger('nutritional_sheet_id');
            $table->softDeletes();
            $table->timestamps();
           
            $table->foreign('diet_id')
            ->references('id')
            ->on('diets')
            ->onDelete('cascade');

            $table->foreign('nutritional_sheet_id')
                ->references('id')
                ->on('nutritional_sheets')
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
        Schema::dropIfExists('nutritional_sheet_diet');
    }
}
