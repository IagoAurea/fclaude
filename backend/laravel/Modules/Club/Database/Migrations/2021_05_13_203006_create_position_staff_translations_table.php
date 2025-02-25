<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionStaffTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_staff_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_staff_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['position_staff_id', 'locale']);

            $table->foreign('position_staff_id')
                ->references('id')
                ->on('position_staff')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position_staff_translations');
    }
}
