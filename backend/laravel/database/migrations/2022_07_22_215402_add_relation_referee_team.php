<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationRefereeTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referees', function (Blueprint $table) {
            $table->foreign('team_id')
            ->nullable()
            ->references('id')
            ->onDelete('cascade')
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
        Schema::table('referees', function (Blueprint $table) {
            $table->dropForeign('referees_team_id_foreign');
        });
    }
}
