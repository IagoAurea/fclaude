<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('rival_team_action');
            $table->string('side_effect')->nullable();
            $table->integer('order')->nullable();
            $table->unsignedBigInteger('sport_id');
            $table->boolean('is_total')->default(false);
            $table->json('calculate_total')->nullable();
            $table->boolean('show')->default(true);
            $table->boolean('show_player')->default(true);
            $table->json('custom_params')->nullable();
            $table->timestamps();

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });

        Schema::create('action_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->string('plural')->nullable();
            $table->unique(['action_id', 'locale']);

            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
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
        Schema::dropIfExists('action_translations');
        Schema::dropIfExists('actions');
    }
}
