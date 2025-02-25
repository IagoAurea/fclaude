<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeekDayTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_day_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('week_day_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['week_day_id', 'locale']);

            $table->foreign('week_day_id')
                ->references('id')
                ->on('week_days')
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
        Schema::dropIfExists('week_day_translations');
    }
}
