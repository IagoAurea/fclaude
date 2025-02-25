<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorships', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('alumn_id');
            $table->unsignedBigInteger('tutorship_type_id');
            $table->text('reason')->nullable();
            $table->text('resume')->nullable();
            $table->unsignedBigInteger('specialist_referral_id');
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('classroom_teachers')
                ->onDelete('cascade');

            $table->foreign('alumn_id')
                ->references('id')
                ->on('alumns')
                ->onDelete('cascade');

            $table->foreign('tutorship_type_id')
                ->references('id')
                ->on('tutorship_types')
                ->onDelete('cascade');

            $table->foreign('specialist_referral_id')
                ->references('id')
                ->on('specialist_referrals')
                ->onDelete('cascade');

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('tutorships');
    }
}
