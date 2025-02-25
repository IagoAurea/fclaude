<?php

namespace Modules\Classroom\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Club\Entities\AcademicYear;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Modules\Classroom\Http\Requests\AssignYearsRequest;
use Modules\Classroom\Http\Requests\AssignTeachersRequest;
use Modules\Classroom\Services\ClassroomAcademicYearService;

class ClassroomAcademicYearController extends BaseController
{
    /**
     * @var object $classroomAcademicYearService
     */
    protected $classroomAcademicYearService;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        ClassroomAcademicYearService $classroomAcademicYearService
    ) {
        $this->classroomAcademicYearService = $classroomAcademicYearService;
    }

    /**
     * List all related academical years to the classroom
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/classroom/{classroom_id}/academic-years",
     *   tags={"Classroom/AcademicYear"},
     *   summary="Retrieves all clasroom's related academical years",
     *   operationId="list-classoom-academic-years",
     *   description="Returns a list of all classroom's academical years",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a listing of all injury prevention items related to a player",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ClassroomAcademicYearListResponse"
     *      )
     *  ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function index(Classroom $classroom)
    {
        $years = $this->classroomAcademicYearService->listYears($classroom);
        return $this->sendResponse($years, 'Classroom academical years', Response::HTTP_CREATED);
    }

    /**
     * Assign the classroom to multiple academical years
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/classroom/{classroom_id}/academic-years/assign",
     *  tags={"Classroom/AcademicYear"},
     *  summary="Assign academical years",
     *  operationId="store-classoom-academic-years",
     *  description="Relates a classroom with a list of academical years",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/AssignClassroomYearsRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Response of done process",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ClassroomAcademicYearStoreResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function assignYears(AssignYearsRequest $request, Classroom $classroom)
    {
        try {
            $response = $this->classroomAcademicYearService->assignYears(
                $request->academic_year_ids,
                $classroom,
                $request->input('physical_teacher_id'),
                $request->input('tutor_id'),
                $request->input('subject_id'),
                $request->input('subject_text')
            );

            return $this->sendResponse($response,
                'Successfully assigned academical years to the classroom', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by assigning multiple alumns to classroom', $exception->getMessage());
        }
    }

    /**
     * Assign the teachers, subject, and tutor to a classroom academic year
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/classroom/{classroom_academic_year_id}/teachers/assign",
     *  tags={"Classroom/AcademicYear"},
     *  summary="Assign teachers to a classroom academical year",
     *  operationId="update-classoom-academic-year",
     *  description="Assign teachers to a classroom academical year",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_academic_year_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/AssignTeachersRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Response of done process",
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function assignTeachers(AssignTeachersRequest $request, ClassroomAcademicYear $classroom_academic_year)
    {
        try {
            $response = $this->classroomAcademicYearService->assignTeachersToClassroom(
                $classroom_academic_year->id,
                $request->input('physical_teacher_id'),
                $request->input('tutor_id'),
                $request->input('subject_id'),
                $request->input('subject_text')
            );

            return $this->sendResponse($response,
                'Successfully assigned academical years to the classroom', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by assigning multiple alumns to classroom', $exception->getMessage());
        }
    }

    /**
     * Assign multiple alumns to an academic year and classroom
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/classroom/{classroom_id}/academic-years/{academic_year_id}/assign-alumns",
     *  tags={"Classroom/AcademicYear"},
     *  summary="Assign alumns to academic year",
     *  operationId="store-alumn-to-classoom-academic-years",
     *  description="Stores list of alumns and relates it to an specific academic year",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/academic_year_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/AssignClassroomAlumnsRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Response of done process",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ClassroomAlumnAcademicYearStoreResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function assignAlumns(Request $request, Classroom $classroom, AcademicYear $academicYear)
    {
        try {
            $this->classroomAcademicYearService->assignAlumns(
                $request->alumn_ids,
                $classroom,
                $academicYear
            );

            return $this->sendResponse(null, 'Successfully added alumns to the classroom', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by assigning multiple alumns to classroom', $exception->getMessage());
        }
    }
}
