<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_groups', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('exercise_session_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('exercise_session_id')
                ->references('id')
                ->on('exercise_sessions');
  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_groups');
    }
}
