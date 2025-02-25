<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Repositories\Interfaces\JobAreaRepositoryInterface;

class JobAreaController extends BaseController
{
    /**
     * @var $jobAreaRepository
     */
    protected $jobAreaRepository;

    public function __construct(JobAreaRepositoryInterface $jobAreaRepository)
    {
        $this->jobAreaRepository = $jobAreaRepository;
    }

    /**
     * Returns a listing of the jobs area.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/jobs-area",
     *  tags={"General"},
     *  summary="Get list Jobs Area - Lista de areas de trabajo",
     *  operationId="list-jobs-area",
     *  security={{"bearerAuth": {} }},
     *  description="Return data list jobs area - Retorna listado de area de trabajo",
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Job Area List",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListJobAreasResponse",
     *      ),
     *  ),
     * )
    */
    public function index()
    {
        $jobsArea = $this->jobAreaRepository->findAllTranslated();
        return $this->sendResponse($jobsArea, 'List Jobs Area');
    }
}
