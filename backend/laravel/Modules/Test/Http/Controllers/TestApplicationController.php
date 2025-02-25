<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Alumn\Entities\Alumn;
use Modules\Player\Entities\Player;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Modules\Test\Services\TestService;
use Modules\Alumn\Services\AlumnService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Services\TestApplicationService;
use Modules\Test\Http\Requests\IndexByPlayerRequest;
use Modules\Test\Repositories\TestApplicationRepository;
use Modules\Test\Http\Requests\StoreTestApplicationRequest;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;

class TestApplicationController extends BaseController
{
    const TEST = 'test';

    use TranslationTrait;

    /**
     * @var $testApplicationRepository
     */
    protected $testApplicationRepository;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var $testService
     */
    protected $testService;

    /**
     * @var $testApplicationService
     */
    protected $testApplicationService;

    /**
     * @var $alumnService
     */
    protected $alumnService;


    public function __construct(
        TestApplicationRepositoryInterface $testApplicationRepository,
        TestRepositoryInterface $testRepository,
        PlayerRepositoryInterface $playerRepository,
        ClassroomRepositoryInterface $classroomRepository,
        TestService $testService,
        TestApplicationService $testApplicationService,
        AlumnService $alumnService
    ) {
        $this->testApplicationRepository = $testApplicationRepository;
        $this->testRepository = $testRepository;
        $this->playerRepository = $playerRepository;
        $this->classroomRepository = $classroomRepository;
        $this->testService = $testService;
        $this->testApplicationService = $testApplicationService;
        $this->alumnService = $alumnService;
    }

    /**
     * Retrieve all tests of classroom created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/tests/application/classroom/list/user",
     *  tags={"Test"},
     *  summary="List all tests applicated in classrooms of user authenticate
     *  - Lista todos los tests aplicados creado en las clases por el usuario",
     *  operationId="list-tests-classroom-user",
     *  description="List all tests applicated in classrooms of user authenticate -
     *  Lista todos los tests aplicados creado en las clases por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
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
    public function getAllTestsClassroomUser()
    {
        $tests = $this->testApplicationService->allTestsByUser(Auth::id(), 'classroom');

        return $this->sendResponse($tests, 'List all tests classroom of user');
    }

    /**
     * Retrieve all tests created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/tests/application/list/user",
     *  tags={"Test"},
     *  summary="List all tests applicated of user authenticate
     *  - Lista todos los tests aplicados creado por el usuario",
     *  operationId="list-tests-user",
     *  description="List all tests applicated of user authenticate -
     *  Lista todos los tests aplicados creado por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
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
    public function getAllTestsUser()
    {
        $tests = $this->testApplicationService->allTestsByUser(Auth::id());

        return $this->sendResponse($tests, 'List all tests of user');
    }

    /**
     * @OA\Post(
     *       path="/api/v1/tests/application",
     *       tags={"Test"},
     *       summary="Stored Test Application - Guardar Una Aplicación del test ",
     *       operationId="test-application-store",
     *       description="Store a new Test Application
     *       - Guarda una nueva Aplicación del test entity_name permitida: rfd, fisiotherapy, test, exercise_session",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StoreTestApplicationRequest")
     *         )
     *       ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response=422,
     *           ref="#/components/responses/unprocessableEntity"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */

    /**
     * Store a newly created resource in storage.
     * @param StoreTestApplicationRequest $request
     * @return Response
     */
    public function store(StoreTestApplicationRequest $request)
    {
        if ($request->entity_name == self::TEST) {
            $permission = $request->player_id ?
                Gate::inspect('store-test', $request->team_id) :
                Gate::inspect('store-test-teacher');

            if (!$permission->allowed()) {
                return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
            }
        }

        try {
            $application =  $request->except('answers');

            $answers = $this->testService->validateAnswers($request->answers, $request->test_id);

            if (!$answers['success']) {
                return $this->sendError('Error filtering responses', $answers['message']);
            }

            $application['answers'] = $answers['data'];

            if ($request->has('player_id')) {
                $application['applicant_id'] = $request->player_id;
                $application['applicant_type'] = Player::class;
            } elseif ($request->has('alumn_id')) {
                $application['applicant_id'] = $request->alumn_id;
                $application['applicant_type'] = Alumn::class;
            } else {
                return $this->sendError('There are no applicants on the request (player_id or alumn_id)', []);
            }

            $application['applicable_id'] = $request->test_id;
            $application['user_id'] = Auth::id();

            $testApplication = $this->testApplicationRepository->createTestApplication($application);

            $testApplication = $this->testService->calculateTestResult($testApplication->id);

            if (!$testApplication['success']) {
                return $this->sendError('Error calculate test responses', $testApplication['message']);
            }

            $test = $this->testApplicationRepository->findTestApplicationDetail($testApplication['data']['id']);

            $testApplication['data']['answers'] = $test->answers;

            return $this->sendResponse(
                $testApplication['data'],
                $this->translator('test_application_store_message'),
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Application', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/application/{code}",
     *       tags={"Test"},
     *       summary="Show Test Application- Ver los datos de un Test Aplicado",
     *       operationId="show-test-code",
     *       description="Return data to Test Application - Retorna los datos de un Test Applicado",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function show($code)
    {
        try {
            $testApplication = $this->testApplicationRepository->findFirstTestApplication($code);

            if (!$testApplication) {
                return $this->sendError("Error", "Test Application not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($testApplication, 'Test information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/application/alumn/{id}",
     *       tags={"Test"},
     *       summary="Show Test  Application- Ver los datos de un Test Aplicado",
     *       operationId="show-test-alumn",
     *       description="Return data to Test Application by a given alumn
     *       - Retorna los datos de un Test Applicado por un alumno dado",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function indexByAlumn($alumn_id, Request $request)
    {
        try {
            $filters = $request->only(['filterByDate', 'orderByDate']);

            $testApplication = $this->testApplicationRepository
                ->findByEntity(
                    Alumn::class,
                    $alumn_id,
                    $filters
                );

            return $this->sendResponse($testApplication, 'Test applications by the alumn ' . $alumn_id);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/application/player/{id}",
     *       tags={"Test"},
     *       summary="Show Test  Application- Ver los datos de un Test Aplicado",
     *       operationId="show-test",
     *       description="Return data to Test Application by a given player
     *       - Retorna los datos de un Test Applicado por un jugador dado",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/id" ),
     *       @OA\Parameter( ref="#/components/parameters/entity_name" ),
     *       @OA\Parameter( ref="#/components/parameters/test_type_code_query" ),
     *       @OA\Parameter( ref="#/components/parameters/test_sub_type_code_query" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function indexByPlayer($player_id, IndexByPlayerRequest $request)
    {
        $permission = Gate::inspect('read-test', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $playerData = $this->playerRepository->findOneBy(
            ['id' => $player_id],
            ['team_id']
        );

        if ($request->team_id != $playerData->team_id) {
            abort(Response::HTTP_FORBIDDEN, $this->translator('user_forbidden'));
        }

        try {
            $filters = $request->only(['filterByDate', 'orderByDate', 'test_type', 'test_sub_type']);

            $filters['applicable_type'] = TestApplicationRepository::CLASS_NAMES[$request->entity_name];

            $testApplication = $this->testApplicationRepository
                ->findByEntity(
                    Player::class,
                    $player_id,
                    $filters
                );

            return $this->sendResponse($testApplication, 'Test applications by the player ' . $player_id);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/team/{team_id}/players",
     *       tags={"Test"},
     *       summary="Get list players test by team - Lista de jugadores con test por equipo",
     *       operationId="list-test-players",
     *       description="Return list players test by team  - Retorna listado de jugadores con test por equipo",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a listing of the Test with the player .
     * @return Response
     */
    public function index(Request $request, $teamId)
    {
        $permission = Gate::inspect('list-test', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $lisOfPlayer = $this->playerRepository->allPlayersTestByTeam($teamId);

        return $this->sendResponse($lisOfPlayer, 'List players test');
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/classroom/{classroom_id}/alumns",
     *       tags={"Test"},
     *       summary="Get list alumns test by classroom - Lista de alumnos con test por clase",
     *       operationId="list-test-alumns",
     *       description="Return list players test by classroom  - Retorna listado de alumnos con test por clase",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/classroom_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a listing of the Test with the alumn.
     * @return Response
     */
    public function indexAlumn($classroomId)
    {
        $classroom = $this->classroomRepository->findOneBy([
            'id' => $classroomId
        ]);

        if (!$classroom) {
            return $this->sendError("Error", "Classroom not found", Response::HTTP_NOT_FOUND);
        }

        $classroomAcademicYearId = $classroom->activeAcademicYears->first()->pivot->id;

        $lisOfAlumns = $this->alumnService->allAlumnsTestByClassroomAcademicYear($classroomAcademicYearId);

        return $this->sendResponse($lisOfAlumns, 'List alumns test');
    }

    /**
     * @OA\Get(
     *        path="/api/v1/tests/application/{code}/pdf",
     *       tags={"Test"},
     *       summary="Get test PDF - Obtener PDF de un test aplicado",
     *       operationId="pdf-test-application",
     *       description="Return pdf test application - Retorna PDF de un test aplicado",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Generate PDF
     *
     * @param $id
     * @return JsonResponse
     */
    public function testApplicationPdf($code)
    {
        try {
            $data = $this->testApplicationRepository->findFirstTestApplication($code);

            if (!$data) {
                return $this->sendError("Error", "Test Application not found", Response::HTTP_NOT_FOUND);
            }

            $type = $data->applicable->code ?? 'index';

            $testType = $data->applicable->test_type->code ?? 'default';

            if (!view()->exists(sprintf('test::%s.%s', $testType, $type))) {
                $type = 'index';
                $testType = 'default';
            }

            $dompdf = App::make('dompdf.wrapper');

            $pdf = $dompdf->loadView(sprintf('test::%s.%s', $testType, $type), compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('test-application-%s.pdf', $code) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving pdf test application', $exception->getMessage());
        }
    }
}
