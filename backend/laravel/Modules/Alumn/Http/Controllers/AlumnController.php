<?php

namespace Modules\Alumn\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Alumn\Entities\Alumn;
use Modules\Alumn\Services\AlumnService;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Modules\Alumn\Http\Requests\AlumnIndexRequest;
use Modules\Alumn\Http\Requests\StoreAlumnRequest;
use Modules\Alumn\Http\Requests\UpdateAlumnRequest;
use Modules\Classroom\Services\ClassroomAcademicYearService;
use Modules\Classroom\Repositories\ClassroomAcademicYearRepository;

class AlumnController extends BaseController
{
    use TranslationTrait;

    const MOTHER_INPUT_VALUES = [
        'mother_email', 'mother_full_name', 'mother_phone', 'mother_mobile_phone'
    ];

    const FATHER_INPUT_VALUES = [
        'father_email', 'father_full_name', 'father_phone', 'father_mobile_phone'
    ];

    const ALUMN_ADDRESS_VALUES = [
        'street',
        'city',
        'postal_code',
        'country_id',
        'province_id',
        'phone',
        'mobile_phone',
    ];

    const FAMILY_ADDRESS_VALUES = [
        'family_address_street',
        'family_address_city',
        'family_address_postal_code',
        'family_address_country_id',
        'family_address_province_id'
    ];

    /**
     * @var $alumnService
     */
    protected $alumnService;

    /**
     * @var $classroomAcademicYearService
     */
    protected $classroomAcademicYearService;

    /**
     * @var $classroomAcadeicYearRepository
     */
    protected $classroomAcadeicYearRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        AlumnService $alumnService,
        ClassroomAcademicYearRepository $classroomAcadeicYearRepository,
        ClassroomAcademicYearService $classroomAcademicYearService
    ) {
        $this->alumnService = $alumnService;
        $this->classroomAcademicYearService = $classroomAcademicYearService;
        $this->classroomAcadeicYearRepository = $classroomAcadeicYearRepository;
    }

    /**
     * Function to list all alumns related to a specific classroom
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/alumns/{classroom_id}",
     *  tags={"Alumn"},
     *  summary="Alumn Index List - Listado de Alumnos",
     *  operationId="alumn-index",
     *  description="Shows a list of alumns depending on the team - Muestra el listado de alumnos de una clase",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/classroom_id" ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_academic_year_id_daily_control_list"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
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
    public function index(AlumnIndexRequest $request, Classroom $classroom)
    {
        $alumns = $this->alumnService->index($request->all(), $classroom);
        
        return $this->sendResponse($alumns, 'Alumns List');
    }

    /**
     * Function to store a new alumn into the database
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/alumns",
     *  tags={"Alumn"},
     *  summary="Store a new Alumn - Inserta informacion de Alumno",
     *  operationId="alumn-store",
     *  description="Stores a new alumn into the database - Agrega un nuevo alumno a la base de datos",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreAlumnRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
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
    public function store(StoreAlumnRequest $request)
    {
        try {
            $motherData = $request->only(self::MOTHER_INPUT_VALUES);
            $fatherData = $request->only(self::FATHER_INPUT_VALUES);
            $familyAddressData = $request->only(self::FAMILY_ADDRESS_VALUES);
            $alumnAddressData = $request->only(self::ALUMN_ADDRESS_VALUES);
            $alumnData =  $request->except($this->getAlumnExceptedValues());

            $alumn = $this->alumnService->store(
                $alumnData,
                $alumnAddressData,
                $motherData,
                $fatherData,
                $familyAddressData,
                $request->image,
                $request->parents_marital_status_id,
            );

            if ($request->has('classroom_academic_year_id')) {
                $classroom_academic_year = $this
                    ->classroomAcadeicYearRepository
                    ->findOneBy(['id' => $request->classroom_academic_year_id]);

                if ($classroom_academic_year) {
                    $this->classroomAcademicYearService->assignAlumns(
                        [$alumn->id],
                        $classroom_academic_year->classroom,
                        $classroom_academic_year->academicYear
                    );
                }
            }
            return $this->sendResponse($alumn, $this->translator('alumn_created'));
        } catch (Exception $exception) {
            return $this->sendError('Error by storing alumn', $exception->getMessage());
        }
    }

    /**
     *  Retrieves full information of a specific player
     *  @param Int $id
     *  @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/almuns/{alumn_id}",
     *      tags={"Alumn"},
     *      summary="Show Alumn - Mostrar Alumno",
     *      operationId="alumn-show",
     *      description="Shows alumn's information - Muestra informacion de alumno",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
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
    public function show(Alumn $alumn)
    {
        try {
            $retrieved = $this->alumnService->show($alumn);

            return $this->sendResponse($retrieved, 'Alumn Information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retieving alumn information', $exception->getMessage());
        }
    }

    /**
     *  Updates information about an specific alumn
     *
     *  @param Request $request
     *  @param Int $id
     *  @return Response
     *
     *  @OA\Put(
     *      path="/api/v1/alumn/{alumn_id}",
     *      tags={"Alumn"},
     *      summary="Updates alumn information - Actualiza informacion de alumno",
     *      operationId="alumn-update",
     *      description="Updates an existent alumn from database - Actualiza un alumno existente de la base de datos",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdateAlumnRequest")
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
    public function update(UpdateAlumnRequest $request, Alumn $alumn)
    {
        try {
            $motherData = $request->only(self::MOTHER_INPUT_VALUES);
            $fatherData = $request->only(self::FATHER_INPUT_VALUES);
            $familyAddressData = $request->only(self::FAMILY_ADDRESS_VALUES);
            $alumnAddressData = $request->only(self::ALUMN_ADDRESS_VALUES);
            $alumnData =  $request->except($this->getAlumnExceptedValues());

            $updated = $this->alumnService->update(
                $alumn,
                $alumnData,
                $alumnAddressData,
                $motherData,
                $fatherData,
                $familyAddressData,
                $request->image,
                $request->parents_marital_status_id,
            );

            return $this->sendResponse($updated, $this->translator('alumn_updated'));
        } catch (Exception $exception) {
            return $this->sendError('Error by updating existent alumn', $exception->getMessage());
        }
    }

    /**
     * Deletes a player record
     * @param $id
     * @return Response
     *
     *  @OA\Delete(
     *      path="/api/v1/alumns/{alumn_id}",
     *      tags={"Alumn"},
     *      summary="Delete Alumn - Eliminar Alumno",
     *      operationId="alumn-delete",
     *      description="Deletes an existent alumn - Elimina un alumno existente",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter(
     *          ref="#/components/parameters/alumn_id"
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
    public function destroy(Alumn $alumn)
    {
        try {
            $deleted = $this->alumnService->delete($alumn->id);
            return $this->sendResponse($deleted, $this->translator('alumn_deleted'), Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting alumn', $exception->getMessage());
        }
    }

    /**
     * Return an array with excepted values
     *
     * @return array
     */
    private function getAlumnExceptedValues()
    {
        return array_merge(
            self::MOTHER_INPUT_VALUES,
            self::FATHER_INPUT_VALUES,
            self::FAMILY_ADDRESS_VALUES,
            self::ALUMN_ADDRESS_VALUES,
            ['image', 'parents_marital_status_id', 'classroom_academic_year_id'],
        );
    }
}
