<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubArrivalTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_arrival_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_arrival_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['club_arrival_type_id', 'locale'], 'club_arrival_type_translation');

            $table->foreign('club_arrival_type_id')
                ->references('id')
                ->on('club_arrival_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_arrival_type_translations');
    }
}
