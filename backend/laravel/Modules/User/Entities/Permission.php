<?php

namespace Modules\User\Entities;

use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\RefreshesPermissionCache;

class Permission extends SpatiePermission
{
    use HasRoles;
    use RefreshesPermissionCache;

    /**
     * The attributes are guarded from storing.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that must not be returned from any query.
     *
     * @var array
     */
    protected $hidden = [
        'guard_name',
        'created_at',
        'updated_at',
    ];

    /**
     * Searchs the permission on the relational table
     *
     * @return object Permission
     */
    public static function search(array $attributes = [])
    {
        return DB::table('model_has_permissions')->where([
            ['permission_id', '=',  $attributes['permission_id']],
            ['model_type', '=', config('auth.providers.users.model')],
            ['model_id', '=', $attributes['model_id']], // user_id
            ['entity_id', '=', $attributes['entity_id']], // Entity which may be a club, team, etc
            ['entity_type', '=', $attributes['entity_type']]
        ]);
    }

    /**
     * Custom function used to store permissions into the relationship
     * in order to be managed
     *
     * @return void
     */
    public static function assign(array $attributes = [])
    {
        return DB::table('model_has_permissions')->updateOrInsert([
            'permission_id' =>  $attributes['permission_id'],
            'model_type'    =>  config('auth.providers.users.model'),
            'model_id'      =>  $attributes['model_id'], // user_id
            'entity_id'     =>  $attributes['entity_id'], // Entity which may be a club, team, etc
            'entity_type'   =>  $attributes['entity_type']
        ]);
    }

    /**
     * Custom function used to remove permissions from the relationship
     * in order to be managed
     *
     * @return void
     */
    public static function unassign(array $attributes = [])
    {
        $perm = static::search($attributes);

        return $perm->delete();
    }

    /**
     * Custom function to assign multiple permissions in one call depending on the
     * list of permission names sent, and extra parameters that references the model
     * and the entity to be related to
     *
     * @param Array $permissionsNames
     * @param Int $modelId
     * @param Int $entityId
     * @param Int $entityType
     *
     * @return void
     */
    public static function bulkAssign(array $permissionsNames, $modelId, $entityId, $entityType)
    {
        foreach ($permissionsNames as $permName) {
            $existent = DB::table('permissions')
                ->where('name', $permName)
                ->first();

            $attributes = [
                'permission_id' =>  $existent->id,
                'model_id'  =>  $modelId,
                'entity_id' =>  $entityId,
                'entity_type'   =>  $entityType
            ];

            static::assign($attributes);
        }

        return true;
    }

    public static function bulkAssignToUsers(array $permissionsNames, array $userIds, $entityId, $entityType)
{
    foreach ($userIds as $modelId) {
        foreach ($permissionsNames as $permName) {
            $existent = DB::table('permissions')
                ->where('name', $permName)
                ->first();

            if ($existent) {
                $attributes = [
                    'permission_id' =>  $existent->id,
                    'model_id'      =>  $modelId,
                    'entity_id'     =>  $entityId,
                    'entity_type'   =>  $entityType
                ];

                static::assign($attributes);
            }
        }
    }

    return true;
}

}
