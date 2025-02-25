<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('club_user_type_id');
            $table->softDeletes();

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('club_user_type_id')
                ->references('id')
                ->on('club_user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_users');
    }
}
