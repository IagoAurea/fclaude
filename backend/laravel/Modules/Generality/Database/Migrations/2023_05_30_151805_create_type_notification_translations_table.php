<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeNotificationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_notification_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_notification_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['type_notification_id', 'locale']);

            $table->foreign('type_notification_id')
                ->references('id')
                ->on('type_notifications')
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
        Schema::dropIfExists('type_notification_translations');
    }
}
