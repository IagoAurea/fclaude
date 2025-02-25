<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('inviter_user_id');
            $table->unsignedBigInteger('invited_user_id')->nullable();
            $table->string('invited_user_email');
            $table->string('status')->default('available');
            $table->uuid('code');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            // Relationships
            $table->foreign('inviter_user_id')
                ->references('id')
                ->on('users');

            $table->foreign('invited_user_id')
                ->references('id')
                ->on('users');

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_invitations');
    }
}
