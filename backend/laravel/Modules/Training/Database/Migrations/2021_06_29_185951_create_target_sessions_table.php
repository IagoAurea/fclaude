<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('sub_content_session_id')->nullable();
            $table->unsignedBigInteger('content_exercise_id');
            $table->unsignedBigInteger('sport_id');

            $table->foreign('sub_content_session_id')
                ->references('id')
                ->on('sub_content_sessions');
            
            $table->foreign('content_exercise_id')
                ->references('id')
                ->on('contents_exercise');
                
            $table->foreign('sport_id')
                ->references('id')
                ->on('sports');
        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('target_sessions');
    }
}
