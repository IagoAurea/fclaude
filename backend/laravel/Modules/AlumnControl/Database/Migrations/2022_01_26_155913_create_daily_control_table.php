<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_control', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumn_id');
            $table->unsignedBigInteger('daily_control_item_id');
            $table->unsignedBigInteger('classroom_academic_year_id');
            $table->unsignedBigInteger('academic_period_id')->nullable();
            $table->integer('count')->default(0);
            $table->timestamp('reset_at')->nullable();
            $table->timestamps();

            $table->foreign('alumn_id')
                ->references('id')
                ->on('alumns')
                ->onDelete('cascade');

            $table->foreign('daily_control_item_id')
                ->references('id')
                ->on('daily_control_items')
                ->onDelete('cascade');

            $table->foreign('classroom_academic_year_id')
                ->references('id')
                ->on('classroom_academic_years')
                ->onDelete('cascade');

            $table->foreign('academic_period_id')
                ->references('id')
                ->on('academic_periods')
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
        Schema::dropIfExists('daily_control');
    }
}
