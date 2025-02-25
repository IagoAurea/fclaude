<?php

namespace Modules\Exercise\Http\Controllers;

use Modules\Sport\Entities\Sport;
use App\Http\Controllers\Rest\BaseController;
use Modules\Exercise\Repositories\Interfaces\ContentExerciseRepositoryInterface;

class ContentExerciseController extends BaseController
{
    /**
     * @var $contentRepository
     */
    protected $contentRepository;


    public function __construct(ContentExerciseRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/exercises/contents/{sport_code}",
     *  tags={"Exercise/Content"},
     *  summary="Exercise Contents Index - Lista de contenidos de ejercicios",
     *  operationId="exercise-content-index",
     *  description="Lists all the exercises content with subcontent and target filter by sport - Lista todos los contenido de ejercicios con subcontenidos y objetivos por deporte",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/sport_code" ),
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
     * Display a listing of contents exercise.
     * @return Response
     */
    public function index(Sport $sport_code)
    {
        $contents = $this->contentRepository->findAllSubcontentsWithTarget($sport_code);

        return $this->sendResponse($contents, 'List Content exercises');
    }
}
