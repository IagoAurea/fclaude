<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('alias');
            $table->integer('shirt_number');
            $table->timestamp('date_birth')->nullable();
            $table->unsignedInteger('gender_id')->nullable();
            $table->unsignedInteger('gender_identity_id')->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('heart_rate', 8, 2)->nullable();
            $table->string('email')->nullable()->unique();
            $table->json('agents')->nullable();
            $table->string('profile')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('laterality_id')->nullable(); // No database relationship intended
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('position_spec_id')->nullable();
            $table->string('position_text')->nullable();
            $table->string('position_spec_text')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->integer('performance_assessment')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('sports_positions');
            $table->foreign('position_spec_id')->references('id')->on('sports_positions_specs');
            $table->foreign('image_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_health_relations');
        Schema::dropIfExists('players');
    }
}
