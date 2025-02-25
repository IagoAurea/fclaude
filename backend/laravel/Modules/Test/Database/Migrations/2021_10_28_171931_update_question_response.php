<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_responses', function (Blueprint $table) {

            $table->boolean('cal_value')->default(false);
            $table->boolean('is_index')->default(false);
            $table->string('laterality')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_responses', function (Blueprint $table) {
            $table->dropColumn('cal_value');
            $table->dropColumn('is_index');
            $table->dropColumn('laterality');
        });
    }
}
