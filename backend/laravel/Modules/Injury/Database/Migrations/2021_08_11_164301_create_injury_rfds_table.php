<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjuryRfdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury_rfds', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->unsignedBigInteger('injury_id');
            $table->double('percentage_complete');
            $table->unsignedBigInteger('current_situation_id');
            $table->boolean('closed')->default(false);
            $table->mediumText('annotations')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('injury_id')
                ->references('id')
                ->on('injuries')
                ->onDelete('cascade');

            $table->foreign('current_situation_id')
                ->references('id')
                ->on('current_situations')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('injury_rfds');
    }
}
