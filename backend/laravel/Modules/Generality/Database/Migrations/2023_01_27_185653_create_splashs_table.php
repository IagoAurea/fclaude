<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplashsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('splashs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->boolean('active');
            $table->boolean('external')->default(false)->index();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')
                ->on('resources')
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
        Schema::dropIfExists('splashs');
    }
}
