<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('package_price_id')->unsigned()->nullable();
            $table->string('interval')->nullable();
            $table->float('amount')->nullable();
            $table->timestamp('current_period_start_at')->nullable();
            $table->timestamp('current_period_end_at')->nullable();

            $table->foreign('package_price_id')
            ->references('id')
            ->on('packages_price');

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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_package_price_id_foreign');
            $table->dropForeign('subscriptions_user_id_foreign');
            $table->dropColumn(['interval', 'package_price_id']);
        });
    }
}
