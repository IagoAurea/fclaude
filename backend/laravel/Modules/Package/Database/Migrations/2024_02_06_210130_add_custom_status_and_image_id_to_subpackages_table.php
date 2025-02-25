<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use function Laravel\Prompts\table;

class AddCustomStatusAndImageIdToSubpackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subpackages', function (Blueprint $table) {
            $table->boolean('custom')->default(0)->comment('1=custom,0=basic');
            $table->boolean('status')->default(1)->comment('1=active,0=disabled');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subpackages', function (Blueprint $table) {
            $table->dropColumn(['custom', 'status']);
        });
    }
}
