<?php

namespace Modules\Health\Http\Controllers;

use Modules\Health\Repositories\Interfaces\AllergyRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class AllergyController extends BaseController
{
    /**
     * @var $allergyRepository
     */
    protected $allergyRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(AllergyRepositoryInterface $allergyRepository)
    {
        $this->allergyRepository = $allergyRepository;
    }

    /**
     * Display a listing of allergies.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/health/allergies",
     *      tags={"Health"},
     *      summary="Get allergies list - Lista de alergias",
     *      operationId="list-allergies",
     *      description="Returns a list of allergy types - Retorna listado de tipos de alergias",
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
        $allergies = $this->allergyRepository->findAllTranslated();

        return $this->sendResponse($allergies, 'List Allergies');
    }
}
