<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubContentSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_content_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('content_exercise_id');

            $table->foreign('content_exercise_id')
                ->references('id')
                ->on('contents_exercise');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_content_sessions');
    }
}
