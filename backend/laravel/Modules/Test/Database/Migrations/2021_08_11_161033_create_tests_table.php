<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->boolean('inverse')->default(FALSE);
            $table->unsignedBigInteger('sport_id')->nullable();
            $table->unsignedBigInteger('test_type_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('unit_group_id')->nullable();
            $table->string('type_valoration_code')->default('percentage');
            $table->double('value')->nullable()->default(100);
            $table->unique(['code', 'sport_id']);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_group_id')
                ->references('id')
                ->on('unit_groups')
                ->onDelete('cascade');

            $table->foreign('test_type_id')
                ->references('id')
                ->on('test_types');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('sport_id')
                ->references('id')
                ->on('sports');

            $table->foreign('type_valoration_code')
                ->references('code')
                ->on('type_valorations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
