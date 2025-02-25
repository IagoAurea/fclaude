<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialistReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_referrals', function (Blueprint $table) {
            $table->id();
            $table->string('code');

            $table->timestamps();
        });

        Schema::create('specialist_referral_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_referral_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['specialist_referral_id', 'locale']);

            $table->foreign('specialist_referral_id')
                ->references('id')
                ->on('specialist_referrals')
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
        Schema::dropIfExists('specialist_referral_translations');
        Schema::dropIfExists('specialist_referrals');
    }
}
