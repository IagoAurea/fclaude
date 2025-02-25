<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Repositories\Interfaces\SeasonRepositoryInterface;

class SeasonController extends BaseController
{
	/**
     * @var $seasonRepository
     */
    protected $seasonRepository;

    public function __construct(SeasonRepositoryInterface $seasonRepository)
    {
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * @OA\Get(
     *  path="/api/v1/seasons",
     *  tags={"General"},
     *  summary="Shows seasons - Lista las temporadas",
     *  operationId="season-list",
     *  description="Shows list seasons - Muestra listado de temporadas",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Response(
     *      response=200,
     *      description="Returns information seasons",
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
     * Display a listing seasons.
     * @return Response
     */
    public function index()
    {
        $seasons = $this->seasonRepository->findAll();

        return $this->sendResponse($seasons, 'List Seasons');
    }
}
