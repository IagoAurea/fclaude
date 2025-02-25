<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Repositories\Interfaces\SubjectivePerceptionEffortRepositoryInterface;

class SubjecPerceptEffortController extends BaseController
{
    /**
     * @var $perceptionEffortRepository
     */
    protected $perceptionEffortRepository;


    public function __construct(
        SubjectivePerceptionEffortRepositoryInterface $perceptionEffortRepository
    )
    {
        $this->perceptionEffortRepository = $perceptionEffortRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/training/subjective-perception-effort",
    *       tags={"ExerciseSession"},
    *       summary="Get list subjective perception effort - Lista de precepción subjetiva del esfuerzo",
    *       operationId="list-subjective-perception-effort",
    *       description="Return data list subjective perception effort  -
    *       Retorna listado de precepción subjetiva del esfuerzo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Display a listing of Subjective Perception effort.
     * @return Response
     */
    public function index()
    {
        $perceptionEffort = $this->perceptionEffortRepository->findAll();

        return $this->sendResponse($perceptionEffort, 'List of Subjective Perception Effort');
    }
}
