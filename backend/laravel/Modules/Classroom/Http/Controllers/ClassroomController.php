<?php

namespace Modules\Classroom\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResourceTrait;
use Modules\Club\Entities\Club;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Gate;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Classroom\Services\ClassroomService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Classroom\Http\Requests\ClassroomStoreRequest;
use Modules\Classroom\Http\Requests\ClassroomUpdateRequest;
use Modules\Classroom\Exceptions\ActiveYearNotFoundException;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class ClassroomController extends BaseController
{
    use ResourceTrait, TranslationTrait;
    /**
     * Repository
     *
     * @var $classroomRepository
     */
    protected $classroomRepository;

    /**
     * Repository
     *
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Repository
     *
     * @var $classroomService
     */
    protected $classroomService;

    /**
     * Instances a new controller class
     *
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param ClassroomService $classroomService
     */
    public function __construct(
        ClassroomRepositoryInterface $classroomRepository,
        ClassroomService $classroomService,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->classroomRepository = $classroomRepository;
        $this->resourceRepository = $resourceRepository;
        $this->classroomService = $classroomService;
    }

    /**
     * Display a list of classrooms by a given user
     *
     * @param Request $request
     * @return Response
     * @OA\Get(
     *  path="/api/v1/classrooms/classrooms-by-user/{user_id}",
     *  tags={"Classroom"},
     *  summary="Classroom Index By User- Classroom list by user",
     *  operationId="classroom-by-user-index",
     *  description="Shows a list of classrooms of a user",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/user_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function indexByUser($user_id)
    {
        $payload = $this->classroomRepository->findByUser($user_id);

        return $this
            ->sendResponse(
                $payload,
                $this->translator('list_of_classrooms')
            );
    }

    /**
     * Display a list of classrooms
     *
     * @param Request $request
     * @return Response
     * @OA\Get(
     *  path="/api/v1/classroom/{club_id}/classrooms",
     *  tags={"Classroom"},
     *  summary="Classroom Index - Classroom list",
     *  operationId="classrooms-index",
     *  description="Shows a list of classrooms of a school center",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index($club_id)
    {
        $permission = Gate::inspect('index-classroom', $club_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $payload = $this->classroomRepository->findByClub($club_id);

            return $this->sendResponse($payload, $this->translator('list_of_classrooms'));
        } catch (ActiveYearNotFoundException $exception) {
            return $this->sendError($this->translator('active_year_not_found'));
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('classroom_error'),
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display a classroom by a given id
     *
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/classroom/{club_id}/classrooms/{classroom_id}",
     *  tags={"Classroom"},
     *  summary="Classroom Show - Details of a given Classroom",
     *  operationId="classrooms-show",
     *  description="Shows the details of a given Classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Parameter( ref="#/components/parameters/classroom_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Example of returning classroom object",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ShowClassroomResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show(Club $club, Classroom $classroom)
    {
        $data = $this->classroomService->show($classroom);

        return $this->sendResponse($data, $this->translator('classroom_data'));
    }

    /**
     * Store a new Classroom
     *
     * @param Request $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/classroom/{club_id}/classrooms",
     *  tags={"Classroom"},
     *  summary="Store classroom",
     *  operationId="classrooms-store",
     *  description="Stores a new classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/ClassroomStoreRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=201,
     *      ref="#/components/responses/responseCreated"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store($club_id, ClassroomStoreRequest $request)
    {
        try {
            $response = $this->classroomService->store($club_id, $request);

            return $this->sendResponse(
                $response,
                $this->translator('classroom_created'),
                Response::HTTP_CREATED
            );
        } catch (ActiveYearNotFoundException $exception) {
            return $this->sendError($this->translator('active_year_not_found'));
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('classroom_error'),
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update Classroom
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/classroom/{club_id}/classrooms/{classrooms_id}",
     *      tags={"Classroom"},
     *      summary="Updates classrooms",
     *      operationId="classroomss-update",
     *      description="Updates a classroom",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\Parameter( ref="#/components/parameters/classrooms_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ClassroomUpdateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function update(ClassroomUpdateRequest $request, $club_id, $id)
    {
        try {
            $updated_data = $this->classroomService->update($request, $club_id, $id);

            return $this->sendResponse(
                $updated_data,
                $this->translator('classroom_updated')
            );
        } catch (ModelNotFoundException $exception) {
            return $this->sendError($this->translator('classroom_not_found'));
        } catch (ActiveYearNotFoundException $exception) {
            return $this->sendError($this->translator('active_year_not_found'));
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('classroom_error'),
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Destroy a classroom
     *
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/{club_id}/classrooms/{classroom_id}",
     *      tags={"Classroom"},
     *      summary="Destroys a classroom",
     *      operationId="classrooms-destroy",
     *      description="Deletes a classroom",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_id" ),
     *      @OA\Response(
     *          response=204,
     *          ref="#/components/responses/resourceDeleted"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function destroy($club_id, $id)
    {
        $response = $this->classroomRepository->findOneBy(['id' => $id, 'club_id' => $club_id]);

        if (!$response) {
            return $this->sendError($this->translator('classroom_not_found'));
        }

        $response->delete();

        return $this->sendResponse(true, $this->translator('classroom_deleted'), Response::HTTP_OK);
    }
}
