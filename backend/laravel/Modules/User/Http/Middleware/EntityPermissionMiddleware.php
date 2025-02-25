<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseTrait;


class EntityPermissionMiddleware
{

    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        try {
            // Check user existance
            if (!Auth::user()) {
                throw UnauthorizedException::notLoggedIn();
            }

            // Get the entity id depending on the route parameter sent
            $entityId = $request->route('id');

            // Get the array of permission strings
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
        
            // Loop through all permissions sent
            foreach ($permissions as $perm) {
                // Check if permission row exists
                $hasPerm = $this->checkEntityPermission(Auth::id(), $entityId, $perm);
                
                // In case it does, just continue with request
                if ($hasPerm) {
                    return $next($request);
                }
            }
        
            throw new Exception("User does not have permissions!");
        } catch (Exception $exception) {
            $error = $this->error($exception->getMessage());
            return response()->json($error, Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * It checks in the permissions relationship table the existance of
     * the registry of a entity permission given to an user in specific
     * 
     * @param Int $userId
     * @param Int $entityId
     * @param String $permissionName
     * 
     * @return Object Permission relation row
     */
    private function checkEntityPermission ($userId, $entityId, $permissionName)
    {
        return DB::table('model_has_permissions')->join(
            'permissions', 'permissions.id', '=', 'model_has_permissions.permission_id'
        )->where(
            'model_has_permissions.entity_id', $entityId
        )->where(
            'model_has_permissions.model_id', $userId
        )->where(
            'permissions.name', $permissionName
        )->first();
    }
}
