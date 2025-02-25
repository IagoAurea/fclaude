<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->string('name');
            $table->string('slug');
            $table->string('color', 7)->nullable();
            $table->string('category');
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('modality_id')->unsigned()->nullable();
            $table->integer('season_id')->unsigned();
            $table->integer('gender_id')->unsigned()->nullable();
            $table->integer('image_id')->unsigned()->nullable();
            $table->integer('cover_id')->unsigned()->nullable();
            $table->integer('sport_id')->unsigned();
            $table->integer('club_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_id')
                ->references('id')
                ->on('team_type');

            $table->foreign('modality_id')
                ->references('id')
                ->on('team_modality');

            $table->foreign('season_id')
                ->references('id')
                ->on('seasons');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources')
                ->onDelete('cascade');

            $table->foreign('cover_id')
                ->references('id')
                ->on('resources');

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports');

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
