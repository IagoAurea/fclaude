<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('skills_id');
            $table->unsignedBigInteger('punctuation_id');
            
           

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('punctuation_id')
                ->references('id')
                ->on('punctuations');

            $table->foreign('skills_id')
                ->references('id')
                ->on('skills');
            
            $table->foreign('player_id')
                ->references('id')
                ->on('players');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_skills');
    }
}
