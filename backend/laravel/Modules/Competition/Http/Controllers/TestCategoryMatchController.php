<?php

namespace Modules\Competition\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Competition\Repositories\Interfaces\TestCategoryMatchRepositoryInterface;

class TestCategoryMatchController extends BaseController
{
     /**
     * Type Competition Repository
     * @var $testCategoryMatchRepository
     */
    protected $testCategoryMatchRepository;

    /**
     * TypeCompetitionsController constructor.
     * @param TestCategoryMatchRepositoryInterface $testCategoryMatchRepository
     */
    public function __construct(TestCategoryMatchRepositoryInterface $testCategoryMatchRepository)
    {
        $this->testCategoryMatchRepository = $testCategoryMatchRepository;
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/test-categories/match",
     *  tags={"Competitions"},
     *  summary="Test categories match - Listado de prueba de categorias de partido",
     *  operationId="test-categories-match",
     *  description="Get Test categories match - Listado de prueba de categorias de partido",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    /**
     * Get all Test Categories Match
     * @return JsonResponse
     */
    public function index()
    {
        $categories = $this->testCategoryMatchRepository->findAll();

        return $this->sendResponse($categories, 'List all test categories match');
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/test-categories/type/{test_code}/match",
     *  tags={"Competitions"},
     *  summary="Test type categories match - Listado de tipos de prueba de categorias de partido",
     *  operationId="test-type-categories-match",
     *  description="Get Test type categories match - Listado de tipos de prueba de categorias de partido",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/test_code" ),
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
    /**
     * Get all Test Categories Match
     * @return JsonResponse
     */
    public function getTypeTestCategories($test_code)
    {
        $types = $this->testCategoryMatchRepository->findByCode($test_code);

        return $this->sendResponse($types, 'List test type categories match');
    }

    
}
