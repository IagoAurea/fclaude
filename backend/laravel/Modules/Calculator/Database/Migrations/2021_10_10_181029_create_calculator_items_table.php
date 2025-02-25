<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatorItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('entity_class');
            $table->string('calculation_var')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->decimal('percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculator_items');
    }
}
