<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyControlItemsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_control_items_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_control_item_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['daily_control_item_id', 'locale']);

            $table->foreign('daily_control_item_id')
                ->references('id')
                ->on('daily_control_items')
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
        Schema::dropIfExists('daily_control_items_translations');
    }
}
