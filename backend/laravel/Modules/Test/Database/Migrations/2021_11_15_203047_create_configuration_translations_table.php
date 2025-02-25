<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('configuration_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description');
            $table->unique(['configuration_id', 'locale']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('configuration_id')
                ->references('id')
                ->on('configurations')  
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
        Schema::dropIfExists('configuration_translations');
    }
}
