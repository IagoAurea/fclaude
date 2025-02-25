<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionalSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritional_sheets', function (Blueprint $table) {
            $table->id();
            $table->boolean('take_supplements');
            $table->boolean('take_diets');
            $table->decimal('activity_factor', 10, 2);
            $table->string('other_supplement')->nullable();
            $table->string('other_diet')->nullable();
            $table->decimal('total_energy_expenditure', 10, 2);
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
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
        Schema::dropIfExists('nutritional_sheets');
    }
}
