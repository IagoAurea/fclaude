<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInGameTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scoutings', function (Blueprint $table) {
            $table->string('in_game_time')->nullable();
            $table->string('in_period_time')->nullable();
            $table->string('in_real_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scoutings', function (Blueprint $table) {
            $table->dropColumn('in_game_time');
            $table->dropColumn('in_period_time');
            $table->dropColumn('in_real_time');
        });
    }
}
