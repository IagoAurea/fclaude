<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Test\Services\TestService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreFormulaRequest;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Test\Repositories\Interfaces\FormulaRepositoryInterface;

class FormulaController extends BaseController
{
    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $formulaRepository
     */
    protected $formulaRepository;

    /**
     * @var $testService
     */
    protected $testService;

    public function __construct(
        TestRepositoryInterface $testRepository,
        FormulaRepositoryInterface $formulaRepository,
        TestService $testService
    )
    {
        $this->testRepository = $testRepository;
        $this->formulaRepository = $formulaRepository;
        $this->testService = $testService;
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/formula",
    *       tags={"Test"},
    *       summary="Stored Formula test - Guardar formula para un Test",
    *       operationId="formula-test-store",
    *       description="Store a new formula Test - Guarda una nueva fomula para el Test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreFormulaRequest")
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
     * @param StoreFormulaRequest $request
     * @return Response
     */
    public function store(StoreFormulaRequest $request)
    {
        $test = $this->testRepository->find($request->test_id);

        if(!$test) {
            return $this->sendError("Error", "Test not found", Response::HTTP_NOT_FOUND);
        }

        $formulas = $this->testService->createFormula($request->formulas,$test->id);

        if (!$formulas['success']) {
            return $this->sendError('Error by Create Formula',$formulas['message']);
        }

        return $this->sendResponse($formulas['data'], 'Formulas stored', Response::HTTP_CREATED);
    }

}
