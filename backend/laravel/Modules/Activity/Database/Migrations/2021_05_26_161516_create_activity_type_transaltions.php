<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTypeTransaltions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['activity_type_id', 'locale']);

            // Relations
            $table->foreign('activity_type_id')
                ->references('id')
                ->on('activity_type')
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
        Schema::dropIfExists('activity_type_translations');
    }
}
