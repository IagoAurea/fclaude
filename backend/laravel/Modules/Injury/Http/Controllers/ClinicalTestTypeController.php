<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\ClinicalTestTypeRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class ClinicalTestTypeController extends BaseController
{
    /**
     * @var $clinicalTestTypeRepository
     */
    protected $clinicalTestTypeRepository;

    /**
     * Creates a new controller instance 
     */
    public function __construct(ClinicalTestTypeRepositoryInterface $clinicalTestTypeRepository)
    {
        $this->clinicalTestTypeRepository = $clinicalTestTypeRepository;
    }

    /**
     * Display a listing of clinical test types
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/clinical-test-types",
     *  tags={"Injury"},
     *  summary="Injury Clinical Test Types Index - Listado de Tipos de Test Clinico de Lesiones",
     *  operationId="list-injury-clinical-test-tpes",
     *  description="Returns a list of injury clinical test types - Retorna listado de severidades de tipos de test clinico de lesiones",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
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
    public function index()
    {
        $clinical_tests = $this->clinicalTestTypeRepository->findAllTranslated();
        return $this->sendResponse($clinical_tests, 'List Clinical Tests');
    }
}
