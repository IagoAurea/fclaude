<?php

namespace Modules\InjuryPrevention\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\InjuryPrevention\Repositories\Interfaces\PreventiveProgramTypeRepositoryInterface;

class PreventiveProgramTypeController extends BaseController
{
    /**
     * @var object $fileService
     */
    protected $preventiveProgramTypeRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(PreventiveProgramTypeRepositoryInterface $preventiveProgramTypeRepository)
    {   
        $this->preventiveProgramTypeRepository = $preventiveProgramTypeRepository;
    }


    /**
     * Retrieves a listing of all Injury Prevention Program types
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/injury-prevention/preventive-program-types",
     *  tags={"InjuryPrevention/ProgramType"},
     *  summary="Retrieves list of preventive program types",
     *  operationId="list-injury-prevention-preventive-program-types",
     *  description="Returns a list of preventive program types",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function index()
    {
        $programTypes = $this->preventiveProgramTypeRepository->findAllTranslated();

        return $this->sendResponse($programTypes, 'List Preventive Program Types');
    }
}
