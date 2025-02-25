<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->string('name');
            $table->integer('image_id')->nullable();
            $table->unsignedBigInteger('type_competition_id');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->tinyInteger('state')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('type_competition_id')
                ->references('id')
                ->on('type_competitions')
                ->onDelete('cascade');
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
}
