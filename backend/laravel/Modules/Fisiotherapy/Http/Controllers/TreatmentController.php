<?php

namespace Modules\Fisiotherapy\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Fisiotherapy\Repositories\Interfaces\TreatmentRepositoryInterface;

class TreatmentController extends BaseController
{
    /**
     * @var $diseaseRepository
     */
    protected $treatmentRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(TreatmentRepositoryInterface $treatmentRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
    }

    /**
    * @OA\Get(
    *  path="/api/v1/fisiotherapy/treatments",
    *  tags={"Fisiotherapy"},
    *  summary="List of all treatments available - Listado de todos los tratamientos disponibles",
    *  operationId="list-fisiotherapy-treatments",
    *  description="Returns a list of all treatments available - Retorna listado de todos los tratamientos disponibles",
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
    /**
     * Display a list of all treatments available.
     *
     * @return Response
     */
    public function index()
    {
        $treatments = $this->treatmentRepository->findAllTranslated();

        return $this->sendResponse($treatments, 'List Treatments');
    }
}
