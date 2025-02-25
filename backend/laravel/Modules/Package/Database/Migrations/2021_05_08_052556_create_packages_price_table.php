<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages_price', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('min_licenses');
            $table->integer('max_licenses');
            $table->double('month');
            $table->double('year');
            $table->unsignedBigInteger('subpackage_id');
            $table->string('stripe_month_id')->nullable();
            $table->string('stripe_year_id')->nullable();

            $table->foreign('subpackage_id')
                ->references('id')
                ->on('subpackages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions_user');
        Schema::dropIfExists('packages_price');
    }
}
