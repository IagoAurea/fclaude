<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeMedicineTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_medicine_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_medicine_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['type_medicine_id', 'locale']);

            $table->foreign('type_medicine_id')
                ->references('id')
                ->on('type_medicines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_medicine_translations');
    }
}
