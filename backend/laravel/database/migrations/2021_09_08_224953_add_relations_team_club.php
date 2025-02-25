<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsTeamClub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_invitations', function (Blueprint $table) {
            $table->foreign('team_id')
            ->nullable()
            ->references('id')
            ->on('teams');
        });

        Schema::table('club_users', function (Blueprint $table) {
            $table->foreign('team_id')
            ->nullable()
            ->references('id')
            ->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_invitations', function (Blueprint $table) {
            $table->dropForeign('club_invitations_team_id_foreign');
        });

        Schema::table('club_users', function (Blueprint $table) {
            $table->dropForeign('club_users_team_id_foreign');
        });
    }
}
