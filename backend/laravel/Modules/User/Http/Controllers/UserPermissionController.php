<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// Repositories
use Modules\User\Services\PermissionService;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\AssignPermissionsRequest;
use Modules\User\Services\UserService;

class UserPermissionController extends BaseController
{

    /**
     * @var object $permissionService
     */
    protected $permissionService;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        PermissionService $permissionService,
        protected UserService $userService,
    ) {
        $this->permissionService = $permissionService;
    }

    /**
     * Retrieves a listing of all permission items set
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/users/permissions/list",
     *  tags={"User/Permissions"},
     *  summary="General permission items list",
     *  operationId="user-permissions-list",
     *  description="Returns a list of all permissions segmented on every module on where it's usage is needed",
     *  security={{"bearerAuth": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="List of all permission items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/PermissionListResponse"
     *      )
     *  ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function index()
    {
        try {
            $permissions = $this->permissionService->listPermissions();

            return $this->sendResponse($permissions, 'Permission Item List');
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Retrieves a list of all permisions related to the player
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/users/permissions/assigned",
     *  tags={"User/Permissions"},
     *  summary="General permission items list",
     *  operationId="user-assigned-permissions-list",
     *  description="Returns a list of all permissions assigned to the logged user",
     *  security={{"bearerAuth": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="List of all permission items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UserPermissionListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function userPermissions(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $permissions = $this->permissionService->listUserPermissions($userId, $request->entityId, $request->entityType);
            return $this->sendResponse($permissions, 'User Permissions List');
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Asigna permisos a múltiples usuarios
     * 
     * @OA\Post(
     *  path="/api/v1/users/permissions/assign",
     *  tags={"User/Permissions"},
     *  summary="Assign permissions to multiple users",
     *  operationId="assign-permissions",
     *  security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          @OA\Property(property="userIds", type="array", @OA\Items(type="integer")),
     *          @OA\Property(property="permissions", type="array", @OA\Items(
     *          type="object",
     *          @OA\Property(property="type", type="string", example="club"),
     *          @OA\Property(property="permissions", type="array", @OA\Items(type="string")),
     *        
     *  )),
     *  )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Permissions assigned successfully",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Permissions assigned successfully"),
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      description="Unauthorized",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response="400",
     *      description="Invalid input data",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string")
     *      )
     *  )
     * )
     */

    public function assignPermissions(AssignPermissionsRequest $request)
    {
        DB::beginTransaction();
        $permissions = $request->input('permissions');
        $userIds = $request->input('userIds');
        $entityId = $request->input('entityId');
        $entityType = $request->input('entityType');

        $response = User::whereIn('id', $userIds)->each(function (User $model) use ($permissions) {
            foreach ($permissions as $key => $permision) {
                if (isset($permision['type'])) {
                    $class = null;
                    try {
                        $class = $this->userService->resolvePermissionClass($permision['type']);
                    } catch (\Throwable $th) {

                    }

                    if ($class) {
                        foreach ($class::all() as $value) {
                            $model->assignMultiplePermissions($permision['permissions'], $value->id, $class);
                        }
                    }

                }

            }

        });

        DB::commit();

        return $this->sendResponse($response, 'Permisos asignados satisfactoriamente');
    }


    // DEPRECATED: Function deprecated by update staff.
    // public function getPermissionsByEntity(Request $request)
    // {
    //     try {
    //         $entityType = $request->type ?? 'club';
    //         $entityId = $request->id;

    //         $permissions = $this->permissionService->listPermissionsByEntity($entityType, $entityId);

    //         return $this->sendResponse($permissions, 'User Permissions List By Entity');
    //     } catch (Exception $exception) {
    //         return $this->sendError('Error', $exception->getMessage());
    //     }
    // }
}
