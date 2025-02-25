<?php

namespace Modules\Health\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Health\Repositories\Interfaces\PhysicalProblemRepositoryInterface;

class PhysicalProblemController extends BaseController
{
    /**
     * @var $physicalRepository
     */
    protected $physicalRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(PhysicalProblemRepositoryInterface $physicalRepository)
    {
        $this->physicalRepository = $physicalRepository;
    }

    /**
     * Display a listing of physical extension problems.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/health/physical-extension-problems",
     *      tags={"Health"},
     *      summary="Get physical extension problems list - Lista de problemas por extension fisica",
     *      operationId="list-physical-extension-problems",
     *      description="Returns a list of physical extension problems - Retorna listado de problemas por extension fisica",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
    */
    public function index()
    {
        $physicalProblems = $this->physicalRepository->findAllTranslated();

        return $this->sendResponse($physicalProblems, 'List Physical exertion problems');
    }

}
