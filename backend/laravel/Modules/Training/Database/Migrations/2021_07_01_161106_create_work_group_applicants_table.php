<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkGroupApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_group_applicants', function (Blueprint $table) {
            $table->id();
            $table->morphs('applicant');
            $table->unsignedBigInteger('work_group_id');
            
            $table->foreign('work_group_id')
                ->references('id')
                ->on('work_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_group_applicants');
    }
}
