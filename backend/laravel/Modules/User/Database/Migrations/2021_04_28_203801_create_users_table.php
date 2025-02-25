<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('active')->default(false);
            $table->smallInteger('gender')->nullable();
            $table->unsignedInteger('gender_identity_id')->nullable();
            $table->string('dni')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->json('phone')->nullable();
            $table->json('mobile_phone')->nullable();
            $table->boolean('is_company')->default(false);
            $table->string('company_name')->nullable();
            $table->string('company_idnumber')->nullable();
            $table->string('company_vat')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_zipcode')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('provider_google_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('cover_id')->nullable();
            $table->unsignedBigInteger('taxes_id')->nullable();
            $table->timestamp('vat_verified_at')->nullable();
            $table->boolean('vat_valid')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index('email');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');

            $table->foreign('province_id')
                ->references('id')
                ->on('provinces');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('cover_id')
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
        Schema::dropIfExists('users');
    }
}
