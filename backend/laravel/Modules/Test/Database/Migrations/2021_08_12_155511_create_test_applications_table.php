<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_applications', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('test_id');
            $table->morphs('applicable');
            $table->morphs('applicant');
            $table->dateTime('date_application');
            $table->unsignedBigInteger('professional_directs_id')->nullable();
            $table->json('result')->nullable();
            $table->double('average')->nullable();
            $table->double('median')->nullable();
            $table->integer('chart_order')->nullable();
            $table->double('score')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('test_id')
                ->references('id')
                ->on('tests');
            
            $table->foreign('professional_directs_id')
                ->references('id')
                ->on('staff_users');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_applications');
    }
}
