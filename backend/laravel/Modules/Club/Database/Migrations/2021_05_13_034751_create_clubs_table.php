<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('clubs')) {
            Schema::create('clubs', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug');

                // School Centre Camps
                $table->string('webpage')->nullable();
                $table->string('email')->nullable();

                // Relationships
                $table->unsignedBigInteger('image_id')->nullable();
                $table->foreign('image_id')
                    ->references('id')
                    ->on('resources');

                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users');

                $table->unsignedBigInteger('club_type_id');
                $table->foreign('club_type_id')
                    ->references('id')
                    ->on('club_types');

                $table->unsignedBigInteger('school_center_type_id')->nullable();
                $table->foreign('school_center_type_id')
                    ->references('id')
                    ->on('school_center_types');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}
