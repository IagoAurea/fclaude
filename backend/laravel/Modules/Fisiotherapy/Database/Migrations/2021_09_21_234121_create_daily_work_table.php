<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_work', function (Blueprint $table) {
            $table->id();
            $table->integer('minutes_duration');
            $table->string('sensations')->nullable();
            $table->string('exploration')->nullable();
            $table->string('tests')->nullable();
            $table->text('observations')->nullable();
            $table->date('work_date');
            $table->json('treatments')->nullable();
            $table->unsignedBigInteger('file_id');
            $table->timestamps();

            $table->foreign('file_id')
                ->references('id')
                ->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_work');
    }
}
