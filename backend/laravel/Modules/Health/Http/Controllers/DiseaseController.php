<?php

namespace Modules\Health\Http\Controllers;

use Modules\Health\Repositories\Interfaces\DiseaseRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class DiseaseController extends BaseController
{
    /**
     * @var $diseaseRepository
     */
    protected $diseaseRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(DiseaseRepositoryInterface $diseaseRepository)
    {
        $this->diseaseRepository = $diseaseRepository;
    }

    /**
     * Display a listing of diseases.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/health/diseases",
     *      tags={"Health"},
     *      summary="Get diseases list - Lista de enfermedades",
     *      operationId="list-diseases",
     *      description="Returns a list of diseases - Retorna listado de enfermedades",
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
        $diseases = $this->diseaseRepository->findAllTranslated();

        return $this->sendResponse($diseases, 'List Diseases');
    }

}
