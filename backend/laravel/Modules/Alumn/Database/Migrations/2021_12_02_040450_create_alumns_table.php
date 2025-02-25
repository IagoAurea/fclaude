<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumns', function (Blueprint $table) {
            $table->id();

            // Obligatory for quick register
            $table->string('list_number'); // Academical required field
            $table->string('full_name');
            $table->unsignedInteger('gender_id'); // No database relationship intended
            $table->unsignedInteger('gender_identity_id')->nullable(); // No database relationship intended

            // Required but not obligatory
            $table->timestamp('date_birth')->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('heart_rate', 8, 2)->nullable();
            $table->string('email')->nullable()->unique();
            $table->unsignedInteger('country_id')->nullable();

            // Extra academical contact fields
            $table->json('academical_emails')->nullable();
            $table->string('virtual_space')->nullable();

            // Academical fields
            $table->boolean('is_new_entry')->default(false);
            $table->boolean('is_advanced_course')->default(false);
            $table->boolean('is_repeater')->default(false);
            $table->boolean('is_delegate')->default(false);
            $table->boolean('is_sub_delegate')->default(false);
            $table->boolean('has_digital_difficulty')->default(false);
            $table->string('acneae_type_text')->nullable();
            $table->unsignedBigInteger('acneae_type_id')->nullable();
            $table->unsignedBigInteger('acneae_subtype_id')->nullable();
            $table->string('acneae_description')->nullable();

            // Sport fields
            $table->boolean('has_sport')->default(false);
            $table->boolean('has_extracurricular_sport')->default(false);
            $table->boolean('has_federated_sport')->default(false);
            $table->unsignedInteger('laterality_id')->nullable(); // No database relationship intended

            // Extra relational fields
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('favorite_sport_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('acneae_type_id')
                ->references('id')
                ->on('acneae_types');

            $table->foreign('acneae_subtype_id')
                ->references('id')
                ->on('acneae_subtypes');

            $table->foreign('image_id')
                ->references('id')
                ->on('resources');

            $table->foreign('favorite_sport_id')
                ->references('id')
                ->on('sports');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumns');
    }
}
