<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityIdToModelHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            // Drop the previous primary indexing
            $table->dropPrimary('model_has_permissions_permission_model_type_primary');

            // Creates a morph relationship
            $table->morphs('entity');

            // Recreate the model primary key
            $table->primary(['permission_id', 'model_id', 'model_type', 'entity_id', 'entity_type'],
                    'model_has_permissions_permission_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {

        });
    }
}
