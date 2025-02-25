<?php

namespace Modules\SchoolCenter\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Club\Entities\Club;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Club\Services\ClubService;
use App\Http\Controllers\Rest\BaseController;
use Modules\SchoolCenter\Http\Requests\CreateSchoolRequest;
use Modules\SchoolCenter\Http\Requests\UpdateSchoolRequest;
use Modules\SchoolCenter\Services\SchoolAcademicYearService;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

class SchoolCenterController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var $clubService
     */
    protected $clubService;

    /**
     * @var $schoolAcademicYearService
     */
    protected $schoolAcademicYearService;

    /**
     * Instances a new controller class
     */
    public function __construct(
        ClubRepositoryInterface $clubRepository,
        ClubService $clubService,
        SchoolAcademicYearService $schoolAcademicYearService
    ) {
        $this->clubRepository = $clubRepository;
        $this->clubService = $clubService;
        $this->schoolAcademicYearService = $schoolAcademicYearService;
    }

    /**
     * Display all the academies related to the user doing the request.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/school-center",
     *      tags={"School"},
     *      summary="School Index - Listado de Escuelas",
     *      operationId="school-index",
     *      description="Shows a list of schools owned by the requesting user -
     *      Muestra el listado de escuelas pertenecientes al usuario que hace la consulta",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
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
     */
    public function index()
    {
        $schools = $this->clubService->index('academic');

        return $this->sendResponse($schools, 'List Schools');
    }

    /**
     * Stores a new school into the database.
     * @return Response
     *
     *  @OA\Post(
     *      path="/api/v1/school-center",
     *      tags={"School"},
     *      summary="Store school - Crear escuela",
     *      operationId="school-store",
     *      description="Stores a new school - Crea una nueva escuela",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/CreateSchoolRequest")
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
     */
    public function store(CreateSchoolRequest $request)
    {
        try {
            $user = Auth::user();

            $schoolData = $request->only(
                'name',
                'image',
                'webpage',
                'email',
                'school_center_type_id',
                'academic_years_json'
            );

            $addressData = $request->only(
                'street',
                'postal_code',
                'city',
                'country_id',
                'province_id',
                'mobile_phone',
                'phone'
            );

            $school = $this->clubService->store($user, $schoolData, $addressData, 'academic');

            $yearsJson = json_decode($request->academic_years_json, true);

            $this->schoolAcademicYearService->storeAcademicYears($school, $yearsJson);

            return $this->sendResponse($school, $this->translator('school_center_store'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing school',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the specified club.
     *
     * @param Int $id
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/school-center/{school_center_id}",
     *      tags={"School"},
     *      summary="Show School - Mostrar Escuela",
     *      operationId="school-show",
     *      description="Shows school's information - Muestra informacion de escuela",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/school_center_id" ),
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
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function show($id)
    {
        try {
            $school = $this->clubService->show($id, 'academic');

            return $this->sendResponse($school, 'School information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving school', $exception->getMessage());
        }
    }

    /**
     * Updates all the school data sent on storage.
     *
     * @param Request $request
     * @param Int $id
     * @return Response
     *
     *  @OA\Post(
     *      path="/api/v1/school-center/{school_center_id}",
     *      tags={"School"},
     *      summary="Updates school information - Actualiza informacion de escuela",
     *      operationId="school-update",
     *      description="Updates an existent school from database -
     *      Actualiza una escuela existente de la base de datos",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/school_center_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdateSchoolRequest")
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
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        try {
            $schoolData = $request->only('name', 'image', 'webpage', 'email', 'school_center_type_id');

            $addressData = $request->only(
                'street',
                'postal_code',
                'city',
                'country_id',
                'province_id',
                'mobile_phone',
                'phone'
            );

            $school = $this->clubService->update($id, $schoolData, $addressData, 'academic');

            return $this->sendResponse($school, $this->translator('school_center_update'));
        } catch (Exception $exception) {
            return $this->sendError('Error by updating school', $exception->getMessage());
        }
    }

    /**
     * Makes a logical school deletion from database.
     *
     * @param Int $id
     * @return Response
     *  @OA\Delete(
     *      path="/api/v1/school-center/{school_center_id}",
     *      tags={"School"},
     *      summary="Delete School - Eliminar Escuela",
     *      operationId="school-delete",
     *      description="Deletes an existent school - Elimina una escuela existente",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter(
     *          ref="#/components/parameters/school_center_id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function destroy($id)
    {
        try {
            $this->clubService->delete($id, 'academic');

            return $this->sendResponse(null, $this->translator('school_center_delete'), Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting school', $exception->getMessage());
        }
    }

    /**
     * Retrieves a list of all alumns related to a school center.
     *
     * @param Int $id
     * @return Response
     *  @OA\Get(
     *      path="/api/v1/school-center/{school_center_id}/alumns",
     *      tags={"School"},
     *      summary="Lists school alumns - Lista alumnos de escuela",
     *      operationId="school-list-alumns",
     *      description="List all alumns related through all classrooms on a school center -
     *      Obtiene a todos los alumnos relacionados con los salones de clases de un centro escolar",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter(
     *          ref="#/components/parameters/school_center_id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function alumns(Club $schoolCenter)
    {
        try {
            $alumns = $this->clubService->getSchoolCenterAlumns($schoolCenter);

            return $this->sendResponse($alumns, 'School Center Alumn List');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving alumn list', $exception->getMessage());
        }
    }
}
