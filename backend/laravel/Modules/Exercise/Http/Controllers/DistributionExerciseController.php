<?php

namespace Modules\Exercise\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Exercise\Repositories\Interfaces\DistributionExerciseRepositoryInterface;

class DistributionExerciseController extends BaseController
{
    /**
     * @var $distributionRepository
     */
    protected $distributionRepository;


    public function __construct(DistributionExerciseRepositoryInterface $distributionRepository)
    {
        $this->distributionRepository = $distributionRepository;
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/exercises/distributions",
     *  tags={"Exercise/Distribution"},
     *  summary="Exercise Distribution Index",
     *  operationId="exercise-distribution-index",
     *  description="Lists all the exercises distribution - Lista todos las distribuiciones de ejercicios",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    /**
     * Display a listing of distribution exercise.
     * @return Response
     */
    public function index()
    {
        $distributions = $this->distributionRepository->findAllTranslated();

        return $this->sendResponse($distributions, 'List Distribution exercises');
    }
}
