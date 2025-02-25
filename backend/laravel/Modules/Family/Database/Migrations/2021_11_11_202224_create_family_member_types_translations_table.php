<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMemberTypesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_member_types_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_member_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['family_member_type_id', 'locale'], 'family_member_trans_type');

            $table->foreign('family_member_type_id')
                ->references('id')
                ->on('family_member_types')
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
        Schema::dropIfExists('family_member_types_translations');
    }
}
