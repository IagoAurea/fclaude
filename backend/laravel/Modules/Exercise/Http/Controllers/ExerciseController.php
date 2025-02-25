<?php

namespace Modules\Exercise\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Exercise\Entities\Exercise;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Modules\Exercise\Services\ExerciseService;
use Modules\Exercise\Services\Exercise3DService;
use Modules\Exercise\Http\Requests\AddTeamsRequest;
use Modules\Exercise\Http\Requests\UpdateLikeRequest;
use Modules\Exercise\Http\Requests\AddClassroomsRequest;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\LikeEntityRepositoryInterface;

class ExerciseController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $exerciseRepository
     */
    protected $exerciseRepository;
    
    /**
     * @var $likeEntityRepository
     */
    protected $likeEntityRepository;

    /**
     * @var $exerciseService
     */
    protected $exerciseService;

    /**
     * @var $exercise3DService
     */
    protected $exercise3DService;


    public function __construct(
        ExerciseRepositoryInterface $exerciseRepository,
        LikeEntityRepositoryInterface $likeEntityRepository,
        ExerciseService $exerciseService,
        Exercise3DService $exercise3DService
    )
    {
        $this->exerciseRepository = $exerciseRepository;
        $this->likeEntityRepository = $likeEntityRepository;
        $this->exerciseService = $exerciseService;
        $this->exercise3DService = $exercise3DService;
    }

    /**
     * Update Like exercise user
     *
     * @OA\Post(
     *  path="/api/v1/exercises/{exercise_id}/user/like",
     *  tags={"Exercise"},
     *  summary="Update like Exercise user - Actualizar like de ejercicio de usuario",
     *  operationId="exercise-like-users",
     *  description="Returns update like exercise user - Actualizar like de ejercicio de usuario",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/exercise_id"),
     *  @OA\RequestBody(
     *    @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="like", type="boolean"),
     *    )
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
    public function updateLike(UpdateLikeRequest $request, $id)
    {
        try {
            $entity = [
                'user_id' => Auth::id(),
                'entity_id' => $id,
                'entity_type' => Exercise::class
            ];

            (bool)$request->like ?
                $this->likeEntityRepository->updateOrCreate($entity) :
                $this->likeEntityRepository->deleteByCriteria($entity);

            $message = (bool)$request->like ? 'like_exercise' : 'dislike_exercise';
            
            return $this->sendResponse(null, $this->translator($message));
        } catch (Exception $exception) {
            return $this->sendError('Error by update like', $exception->getMessage());
        }
    }

    /**
     * Retrieve list teams by exercise
     *
     * @OA\Get(
     *  path="/api/v1/exercises/{exercise_id}/teams/list",
     *  tags={"Exercise/Team"},
     *  summary="Exercise list teams - lista equipos de ejercicio",
     *  operationId="exercise-list-teams",
     *  description="Returns exercise list teams - Devuelve lista equipos de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/exercise_id"),
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
    public function listTeams($id)
    {
        try {
            $add = $this->exerciseService->listEntitiesByExercise($id);

            return $this->sendResponse($add, 'List teams by exercise');
        } catch (Exception $exception) {
            return $this->sendError('Error by list teams', $exception->getMessage());
        }
    }

    /**
     * Retrieve list classrooms by exercise
     *
     * @OA\Get(
     *  path="/api/v1/exercises/{exercise_id}/classrooms/list",
     *  tags={"Exercise/Team"},
     *  summary="Exercise list classrooms - lista clases de ejercicio",
     *  operationId="exercise-list-classroom",
     *  description="Returns exercise list classrooms - Devuelve lista clases de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/exercise_id"),
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
    public function listClassrooms($id)
    {
        try {
            $add = $this->exerciseService->listEntitiesByExercise($id, 'teacher');

            return $this->sendResponse($add, 'List classrooms by exercise');
        } catch (Exception $exception) {
            return $this->sendError('Error by list classrooms ', $exception->getMessage());
        }
    }

    /**
     * Asign or Update teams to exercise
     *
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/exercises/{exercise_id}/teams/assign",
     *  tags={"Exercise/Team"},
     *  summary="Exercise Add or update teams to exercise",
     *  operationId="exercise-add-update-teams",
     *  description="Stores or update teams to exercise - Agrega o actualiza equipos a ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/exercise_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/AddTeamsRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
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
    public function addOrUpdateTeams(AddTeamsRequest $request)
    {
        try {
            $addOrUpdate = $this->exerciseService->updateEntitiesToExercise(
                $request->exercise_id, Team::class, $request->teams
            );

            return $this->sendResponse($addOrUpdate, trans('exercise::messages.exercise_add_teams'));
        } catch (Exception $exception) {
            return $this->sendError('Error by storing exercise to teams', $exception->getMessage());
        }
    }

    /**
     * Asign or Update classrooms to exercise
     *
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/exercises/{exercise_id}/classrooms/assign",
     *  tags={"Exercise/Team"},
     *  summary="Exercise Add or update classrooms to exercise",
     *  operationId="exercise-add-update-classrooms",
     *  description="Stores or update classrooms to exercise - Agrega o actualiza classrooms a ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/exercise_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/AddClassroomsRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
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
    public function addOrUpdateClassrooms(AddClassroomsRequest $request)
    {
        try {
            $addOrUpdate = $this->exerciseService->updateEntitiesToExercise(
                $request->exercise_id, Classroom::class, $request->classrooms
            );

            return $this->sendResponse($addOrUpdate, trans('exercise::messages.exercise_add_classrooms'));
        } catch (Exception $exception) {
            return $this->sendError('Error by storing exercise to classrooms', $exception->getMessage());
        }
    }

    /**
     * Returns an exercise pdf
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/exercises/{code}/pdf",
     *  tags={"Exercise"},
     *  summary="PDF exercise - PDF de ejercicio",
     *  operationId="exercise-pdf",
     *  description="Returns exercise PDF
     *  Devuelve PDF de un ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
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
    public function generatePdf($exercise_code)
    {
        $exercise = $this->exerciseRepository->findOneBy(['code' => $exercise_code]);

        $exercise->materials = $this->exercise3DService->listMaterials($exercise);
        $exercise->contents;
        $exercise->distribution;
        $exercise->teams;
        $exercise->sport;
        $exercise->targets;
        $exercise->intensityRelation;

        try {
            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('exercise::exercise', compact('exercise'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>
                    'attachment; filename="' . sprintf('exercise-%s.pdf', $exercise->code) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving pdf exercise',
                $exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
