<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsActivityTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('activities', function (Blueprint $table) {
        //     $table->foreign('team_id')
        //     ->nullable()
        //     ->references('id')
        //     ->on('teams');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('activities', function (Blueprint $table) {
        //      $table->dropForeign('activities_team_id_foreign');
        //  });
    }
}
