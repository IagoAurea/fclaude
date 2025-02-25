<?php

namespace Modules\Injury\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Repositories\Interfaces\MechanismInjuryRepositoryInterface;

class MechanismInjuryController extends BaseController
{
    /**
     * @var object
     */
    protected $mechanismInjuryRepository;

    /**
     * Creates a new contoller instance 
     */
    public function __construct(MechanismInjuryRepositoryInterface $mechanismInjuryRepository)
    {
        $this->mechanismInjuryRepository = $mechanismInjuryRepository;
    }

    /**
     * Display a listing of mechanisms of injury
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/injuries/mechanisms-injury",
     *      tags={"Injury"},
     *      summary="Get injury mechanisms list - Lista de mecanismos de lesion",
     *      operationId="list-injury-mechanisms list",
     *      description="Returns a list of injury mechanisms - Retorna listado de mecanismos de lesion",
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
        $mechanismsInjury = $this->mechanismInjuryRepository->findAllTranslated();

        return $this->sendResponse($mechanismsInjury, 'List Mechanisms of injury');
    }
}
