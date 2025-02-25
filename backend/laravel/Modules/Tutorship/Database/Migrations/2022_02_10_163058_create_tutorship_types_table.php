<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorshipTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorship_types', function (Blueprint $table) {
            $table->id();
            $table->string('code');

            $table->timestamps();
        });

        Schema::create('tutorship_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutorship_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['tutorship_type_id', 'locale']);

            $table->foreign('tutorship_type_id')
                ->references('id')
                ->on('tutorship_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutorship_type_translations');
        Schema::dropIfExists('tutorship_types');
    }
}
