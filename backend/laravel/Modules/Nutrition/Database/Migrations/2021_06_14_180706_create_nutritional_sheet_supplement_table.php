<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionalSheetSupplementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritional_sheet_supplement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplement_id');
            $table->unsignedBigInteger('nutritional_sheet_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('supplement_id')
            ->references('id')
            ->on('supplements');

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
        Schema::dropIfExists('nutritional_sheet_supplement');
    }
}
