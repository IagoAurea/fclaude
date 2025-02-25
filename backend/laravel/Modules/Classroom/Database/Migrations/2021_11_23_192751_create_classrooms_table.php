<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('observations')->nullable();
            $table->unsignedBigInteger('age_id');
            $table->unsignedBigInteger('club_id');
            $table->string('color')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('cover_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('age_id')
                ->references('id')
                ->on('classroom_ages')
                ->onDelete('cascade');

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('cover_id')
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
        Schema::dropIfExists('classrooms');
    }
}
