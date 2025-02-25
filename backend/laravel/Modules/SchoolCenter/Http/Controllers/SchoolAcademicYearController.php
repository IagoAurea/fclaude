<?php

namespace Modules\SchoolCenter\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Club\Entities\Club;
use Modules\Club\Entities\AcademicYear;
use App\Http\Controllers\Rest\BaseController;
use Modules\SchoolCenter\Services\SchoolAcademicYearService;
use Modules\SchoolCenter\Http\Requests\StoreSchoolAcademicalYearsRequest;
use Modules\SchoolCenter\Http\Requests\UpdateSchoolAcademicalYearsRequest;

class SchoolAcademicYearController extends BaseController
{
    use ResourceTrait;

    /**
     * @var $schoolAcademicYearService
     */
    protected $schoolAcademicYearService;

    /**
     * Creates a new controller instance 
     */
    public function __construct(SchoolAcademicYearService $schoolAcademicYearService)
    {
        $this->schoolAcademicYearService = $schoolAcademicYearService;
    }

    /**
     * Display all the academies related to the user doing the request.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/school-center/{school_center_id}/academic-years",
     *  tags={"School/AcademicYears"},
     *  summary="School Academic Years Index - Listado de Lapsos Escolares",
     *  operationId="school-academic-years-index",
     *  description="Shows a list of schools related academic years",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/school_center_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Data of school with the academic years items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/SchoolAcademicYearsListReponse"
     *      )
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
    public function index(Club $school)
    {
        $schools = $this->schoolAcademicYearService->list($school);

        return $this->sendResponse($schools, 'List School Academic Years');
    }

    /**
     * Stores a set of new academic years into the database.
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/school-center/{school_center_id}/academic-years",
     *  tags={"School/AcademicYears"},
     *  summary="Store School Academic Years - Almacena Listado de Lapsos Escolares",
     *  operationId="school-academic-years-store",
     *  description="Stores a list of schools related academic years",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/school_center_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreSchoolAcademicalYearsRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Stored academic years related to the school",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreSchoolAcademicYearsResponse"
     *      )
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
    public function store(Club $school, StoreSchoolAcademicalYearsRequest $request)
    {
        try {
            $years = $this->schoolAcademicYearService->storeAcademicYears($school, $request->academic_years);

            return $this->sendResponse($years, 'School academic years stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing academic years',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Stores a set of new academic years into the database.
     * @return Response
     * 
     * @OA\Put(
     *  path="/api/v1/school-center/{school_center_id}/academic-years/{classroom_academic_year_id}",
     *  tags={"School/AcademicYears"},
     *  summary="Update School Academic Years - Actualiza Lapso Escolar",
     *  operationId="school-academic-years-update",
     *  description="Update a academic years",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/school_center_id" ),
     *  @OA\Parameter(ref="#/components/parameters/classroom_academic_year_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateSchoolAcademicalYearsRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Updated academic year related to the school",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreSchoolAcademicYearsResponse"
     *      )
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
    public function update(Club $school, $academicYearId, UpdateSchoolAcademicalYearsRequest $request)
    {
        try {
            $years = $this->schoolAcademicYearService->updateAcademicYears(
                $school, $academicYearId, $request->academic_years);

            return $this->sendResponse($years, 'School academic year updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating academic years', $exception->getMessage());
        }
    }

    /**
     * Makes a logical school deletion from database.
     * 
     * @param Int $id
     * @return Response
     * @OA\Delete(
     *  path="/api/v1/school-center/{school_center_id}/academic-years/{classroom_academic_year_id}",
     *  tags={"School/AcademicYears"},
     *  summary="Delete A School Academic  - Borra un Item de Lapso Escolar",
     *  operationId="school-academic-years-delete",
     *  description="Deletes a single scholar year",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/school_center_id" ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/school_center_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_academic_year_id"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Deleted academic year",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DeleteSchoolAcademicYearResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
     */
    public function destroy(Club $school, AcademicYear $academicYear)
    {
        try {
            $deleted = $this->schoolAcademicYearService->delete($academicYear);

            return $this->sendResponse($deleted, 'School academic years deleted', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting academic year',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
