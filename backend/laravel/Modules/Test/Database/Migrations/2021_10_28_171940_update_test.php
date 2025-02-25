<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->unsignedBigInteger('test_sub_type_id')->nullable();

            $table->foreign('test_sub_type_id')
                ->references('id')
                ->on('test_sub_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropForeign('tests_test_sub_type_id_foreign');
            $table->dropColumn('test_sub_type_id');
        });
    }
}
