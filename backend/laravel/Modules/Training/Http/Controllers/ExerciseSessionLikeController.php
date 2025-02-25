<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreExerciseSessionLikeRequest;
use Modules\Training\Repositories\Interfaces\ExerciseSessionLikeRepositoryInterface;

class ExerciseSessionLikeController extends BaseController
{
    /**
     * @var $sessionLikeRepository
     */
    protected $sessionLikeRepository;


    public function __construct(
        ExerciseSessionLikeRepositoryInterface $sessionLikeRepository
    )
    {
        $this->sessionLikeRepository = $sessionLikeRepository;
    }

     /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $sessionLikes = $this->sessionLikeRepository->findAll();

        return $this->sendResponse($sessionLikes, 'List of Likes');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/likes/exercise-sessions",
    *       tags={"ExerciseSession"},
    *       summary="Stored Like - guardar un nuevo me gusta a la sesión ",
    *       operationId="like-store",
    *       description="Store a new like - Guarda un nuevo me gusta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreExerciseSessionLikeRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Store a new Exercise Session.
     * @param StoreExerciseSessionLikeRequest $request
     * @return Response
     */
    public function store(StoreExerciseSessionLikeRequest $request)
    {
        try {
            $request['user_id'] = Auth::id(); 
            $sessionLikes = $this->sessionLikeRepository->create($request->all());

            return $this->sendResponse($sessionLikes, 'Like stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Like', $exception->getMessage());
        }
    }


    /**
    * @OA\Get(
    *       path="/api/v1/training/likes/exercise-sessions/{exercise_session_code}",
    *       tags={"ExerciseSession"},
    *       summary="Get list likes by session - Lista de me gusta de una sesión",
    *       operationId="list-like-session",
    *       description="Return data likes to session  - Retorna listado de me gusta de una sesión",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_code" ),
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
     * Display a listing of Likes by session.
     * @param int $exercise_session_code
     * @return Response
     */
    public function lisBySession($exercise_session_code)
    {
        $sessionLikes = $this->sessionLikeRepository->findAllBySessionCode($exercise_session_code);

        return $this->sendResponse($sessionLikes, 'List of Likes By Session');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/likes/exercise-sessions/team/{team_id}",
    *       tags={"ExerciseSession"},
    *       summary="Get list likes by team - Lista de me gusta de  sesión por equipo",
    *       operationId="list-likes-team",
    *       description="Return data likes to session  - Retorna listado de me gusta  de sesión por equipo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/team_id" ),
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
     * Display a listing Like by Team.
     * @param int $team_id
     * @return Response
    */
    public function lisByTeam($team_id)
    {
        $sessionLikes = $this->sessionLikeRepository->findAllByTeamId($team_id);

        return $this->sendResponse($sessionLikes, 'List of Exercise Sessions Likes By Team');
    }

}
