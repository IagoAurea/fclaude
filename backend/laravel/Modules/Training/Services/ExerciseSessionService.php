<?php

namespace Modules\Training\Services;

use Exception;
use App\Helpers\Helper;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use Modules\Alumn\Entities\Alumn;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Club\Entities\ClubType;
use Illuminate\Support\Facades\Auth;
use Modules\Test\Services\TestService;
use Modules\Activity\Events\ActivityEvent;
use Modules\Classroom\Entities\Classroom;
use Modules\Training\Entities\ExerciseSession;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\LikeEntityRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionPlaceRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionExerciseRepositoryInterface;

class ExerciseSessionService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var object $exerciseSessionRepository
     */
    protected $exerciseSessionRepository;

    /**
     * @var object $exerciseSessionPlaceRepository
     */
    protected $exerciseSessionPlaceRepository;

    /**
     * @var object $exerciseSessionsRelationsRepository
     */
    protected $exerciseSessionsRelationsRepository;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $testApplicationRepository
     */
    protected $testApplicationRepository;

    /**
     * @var object $likeEntityRepository
     */
    protected $likeEntityRepository;

    /**
     * @var object $playerRepository
     */
    protected $playerRepository;
    
    /**
     * @var object $exerciseRepository
     */
    protected $exerciseRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;
    
    /**
     * @var $testService
     */
    protected $testService;

    /**
     * @var object $helper
     */
    protected $helper;

    /**
     * Creates a new service instance
     */
    public function __construct(
        ExerciseSessionRepositoryInterface $exerciseSessionRepository,
        ExerciseSessionPlaceRepositoryInterface $exerciseSessionPlaceRepository,
        ExerciseSessionExerciseRepositoryInterface $exerciseSessionsRelationsRepository,
        ExerciseRepositoryInterface $exerciseRepository,
        TestRepositoryInterface $testRepository,
        TestApplicationRepositoryInterface $testApplicationRepository,
        LikeEntityRepositoryInterface $likeEntityRepository,
        PlayerRepositoryInterface $playerRepository,
        ClubRepositoryInterface $clubRepository,
        TestService $testService,
        Helper $helper
    ) {
        $this->exerciseSessionRepository = $exerciseSessionRepository;
        $this->exerciseSessionPlaceRepository = $exerciseSessionPlaceRepository;
        $this->exerciseSessionsRelationsRepository = $exerciseSessionsRelationsRepository;
        $this->testRepository = $testRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->testApplicationRepository = $testApplicationRepository;
        $this->likeEntityRepository = $likeEntityRepository;
        $this->playerRepository = $playerRepository;
        $this->clubRepository = $clubRepository;
        $this->testService = $testService;
        $this->helper = $helper;
        ini_set('max_execution_time', 180);

    }
    /**
     * Retrieve all exercise sessions type sport by user
     */
    public function allExerciseSessionsByUser($user_id, $type = 'team')
    {
        $club_type = $type == 'team' ? ClubType::CLUB_TYPE_SPORT : ClubType::CLUB_TYPE_ACADEMIC;

        $relations = $type == 'team' ? ['teams'] : ['classrooms'];

        $clubs = $this->clubRepository->findUserClubs($user_id, $club_type, [], $relations);

        $relations_hidden = ['users'];

        if($type != 'team') {array_push($relations_hidden, 'teams'); }

        $clubs->makeHidden($relations_hidden);

        $total_exercise_sessions = $type == 'team' ?
            $this->totalExerciseSessionsTeam($clubs) :
            $this->totalExerciseSessionsClassroom($clubs);

        return [
            'clubs' => $clubs,
            'total_exercise_sessions' => $total_exercise_sessions
        ];
    }

    /**
     * Calculate total exercise sessions by Classroom
     */
    private function totalExerciseSessionsClassroom($schools_center)
    {
        return $schools_center->map(function($school_center) {

            return $school_center->classrooms->map(function($classroom) {
                $classroom->exercise_sessions = $this->exerciseSessionRepository
                    ->findAllExerciseSessionsByUserAndEntity(Auth::id(), Classroom::class, $classroom->id);

                return $classroom->exercise_sessions->count();
            })->sum();
        })->sum();
    }

    /**
     * Calculate total exercise sessions by Team
     */
    private function totalExerciseSessionsTeam($clubs)
    {
        return $clubs->map(function($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function($team) {
                $team->exercise_sessions = $this->exerciseSessionRepository
                    ->findAllExerciseSessionsByUserAndEntity(Auth::id(), Team::class, $team->id);

                return $team->exercise_sessions->count();
            })->sum();
        })->sum();
    }

     /**
     * Retrieves detail test application
     *
     * @return array
     */
    public function getDetailTestApplication($test_name, $exercise_session, $player_id)
    {
        $type = sprintf('exercise_session_%s', $test_name);

        $player = $this->playerRepository->findOneBy(['id' => $player_id]);

        $application = $this->testApplicationRepository
            ->findApplicationSessionExercise($type, $exercise_session, $player);

        if (!$application) {
            $test['result'] = null;

            return $test;
        }
        
        $test = $this->testRepository->findTestAll($application->test_id, app()->getLocale())->toArray();

        $test['result'] = $application->result;
        
        $application_data = $this->testApplicationRepository->findTestApplicationAll($application->id, false);

        if ($application_data) {
            $test['previous_application'] = $application_data;
        }

        return $test;
    }

    /**
     * Update order session exercise
     */
    public function updateOrderSessionExercise($request, $entity)
    {
        foreach ($request->sessions as $session) {
            $this->exerciseSessionRepository->update(
                ['order' => $session['order']],
                ['id' => $session['id'], 'entity_type' => get_class($entity), 'entity_id' => $entity->id],
                true
            );
        }
    }

    /**
     * Retrieve list exercises available by session exercise
     */
    public function listExercises($code, $entity)
    {
        $session_exercises = $this->exerciseSessionRepository->findExerciseSessionById($code);
        
        $exercises_id = [];
        
        foreach ($session_exercises->exercise_session_exercises as $exercise_session) {
            array_push($exercises_id, $exercise_session->exercise->id);
        }

        $exercises = $this->exerciseRepository->findByEntity(null, $entity);

        return $this->filterExerciseInSession($exercises, $exercises_id);
    }

    /**
     * Retrieves a test application
     *
     * @return array
     */
    public function testApplication($request)
    {
        $application =  $request->except(['answers','entity_name']);

        if ($request->has('player_id')) {
            $application['applicant_id'] = $request->player_id;
            $application['applicant_type'] = Player::class;
        } elseif ($request->has('alumn_id')) {
            $application['applicant_id'] = $request->alumn_id;
            $application['applicant_type'] = Alumn::class;
        } else {
            abort(
                response()->error('There are no applicants on the request (player_id or alumn_id)',
                Response::HTTP_NOT_FOUND)
            );
        }

        $answers = $this->testService->validateAnswers($request['answers'], $request['test_id']);

        if (!$answers['success']) {
            abort(response()->error($answers['message'], Response::HTTP_NOT_FOUND));
        }

        $application['answers'] = $answers['data'];
        $application['user_id'] = Auth::id();
        $application['entity_name'] = "exercise_session";
        
        $before_application = $this->testApplicationRepository->findOneBy([
            'applicable_type' => ExerciseSession::class,
            'applicable_id' => $request['applicable_id'],
            'test_id' => $request['test_id'],
            'applicant_id' => $application['applicant_id'],
            'applicant_type' => $application['applicant_type']
        ]);

        $testApplication = !$before_application ?
            $this->testApplicationRepository->createTestApplication($application) :
            $testApplication = $this->testApplicationRepository->updateTestApplication(
                $before_application->id, $application
            );
    
        
        $result = $this->testService->calculateTestResult($testApplication->id);

        $test = $this->testRepository->find($request['test_id']);

        $percentage = 0;

        if ($test->type_valoration_code == "points") {
            $percentage = ($result['data']['value'] * 100) / intval($test->value);
        }

        $result['data']['percentage'] = $percentage;

        return $result;
    }

    /**
     * Retrieve list materials exercise session
     */
    public function listMaterials($entity, $code)
    {
        $exercises_session = $this->exerciseSessionRepository->findOneBy([
            'code' => $code,
            'entity_id' => $entity->id
        ]);

        $excercises = $exercises_session->exercises;

        $materials = [];

        $url_images = sprintf('%s/%s/%s', config('resource.url'), 'sim3d', 'objects');

        foreach ($excercises as $exercise) {
            $threeD = $exercise['3d'];

            if (!$threeD) { continue; }

            $threeD = json_decode($threeD, true);

            $objects = $threeD['objetos'];

            if (count($objects) == 0) { continue; }

            foreach ($objects as $object) {
                $key = array_search($object['id'], array_column($materials, 'id'));

                if (is_numeric($key)) {
                    $materials[$key]['count'] += 1;
                } else {
                    array_push($materials, [
                        'id' => $object['id'],
                        'full_url' => sprintf('%s/%s.%s', $url_images, $object['id'], 'png'),
                        'name' => trans($object['id']),
                        'count' => 1
                    ]);
                }
            }
        }

        return $materials;
    }

    /**
     * Update the duration, intensity and difficulty for an exercise session
     */
    public function updateDurationIntensityDifficultyExerciseSession($exercise_session_id)
    {
        $intensities = 0;
        $difficulties = 0;
        $durations = [];

        $session_exercise = $this->exerciseSessionRepository->findOneBy(['id' => $exercise_session_id]);

        $exercises = $session_exercise->exercise_session_exercises;
        
        $count_exercises = count($exercises);

        foreach ($exercises as $exercise) {
            $intensities += $exercise->intensity ?? 0;
            $difficulties += $exercise->difficulty ?? 0;
            $duration = $exercise->duration ?? '00:00';
            array_push($durations, $duration);
        }

        $total_durations = $this->helper->sumTimeHoursMinutes($durations);
        $total_difficulties = $count_exercises > 0 ? round($difficulties / $count_exercises) : 0;
        $total_intensities = $count_exercises > 0 ? round($intensities / $count_exercises) : 0;

        $session_exercise->update([
            'duration' => $total_durations,
            'difficulty' => $total_difficulties,
            'intensity' => $total_intensities
        ]);
    }

    /**
     * Retrieves a list of exercises related to the entity sent
     * @return ExerciseSession[]
     *
     * @OA\Schema(
     *  schema="ListExerciseSessionResponse",
     *  type="object",
     *  description="Returns the list of team exercises",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of Exercise Session By Search"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="author", type="string", example="string"),
     *          @OA\Property(property="title", type="string", example="string"),
     *          @OA\Property(property="icon", type="string", example="string"),
     *          @OA\Property(property="difficulty", type="int64", example="1"),
     *          @OA\Property(property="intensity", type="int64", example="1"),
     *          @OA\Property(property="duration", type="string", example="30:25"),
     *          @OA\Property(property="number_exercises", type="int64", example="1"),
     *          @OA\Property(property="materials", type="string", example="string"),
     *          @OA\Property(property="type_exercise_session_id", type="int64", example="1"),
     *          @OA\Property(property="training_period_id", type="int64", example="1"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(
     *              property="exercises",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="title", type="string", example="1"),
     *                  @OA\Property(property="resource_id", type="int64", example="1"),
     *                  @OA\Property(property="resource", type="string", example="string"),
     *                  @OA\Property(
     *                      property="pivot",
     *                      type="object",
     *                      @OA\Property(property="exercise_session_id", type="int64", example="1"),
     *                      @OA\Property(property="exercise_id", type="int64", example="1"),
     *                      @OA\Property(property="created_at", format="date-time", example="2020-01-01 00:00:00"),
     *                      @OA\Property(property="updated_at", format="date-time", example="2020-01-01 00:00:00"),
     *                  ),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function list($requestParams, $entity)
    {
        try {
            $session_exercises = $this->exerciseSessionRepository->searchExerciseSessions($requestParams, $entity);

            foreach ($session_exercises as $session_exercise) {
                $session_exercise->like = $this->getLike($session_exercise->id);
            }

            return $session_exercises;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Stores and returns a new stored exercise
     * @return ExerciseSession
     *
     * @OA\Schema(
     *  schema="StoreExerciseSessionResponse",
     *  type="object",
     *  description="Returns recently inserted exercise session",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Stored a new exercise session item"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="code", type="string", example="string"),
     *      @OA\Property(property="author", type="string", example="string"),
     *      @OA\Property(property="title", type="string", example="string"),
     *      @OA\Property(property="icon", type="string", example="string"),
     *      @OA\Property(property="difficulty", type="int64", example="1"),
     *      @OA\Property(property="intensity", type="int64", example="1"),
     *      @OA\Property(property="duration", type="string", example="30:25"),
     *      @OA\Property(property="number_exercises", type="int64", example="1"),
     *      @OA\Property(property="materials", type="string", example="string"),
     *      @OA\Property(property="type_exercise_session_id", type="int64", example="1"),
     *      @OA\Property(property="training_period_id", type="int64", example="1"),
     *      @OA\Property(property="entity_type", type="string", example="string"),
     *      @OA\Property(property="entity_id", type="int64", example="1"),
     *      @OA\Property(
     *          property="entity",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="image",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="url", type="string", example="string"),
     *          @OA\Property(property="mime_type", type="string", example="string"),
     *          @OA\Property(property="size", type="int64", example="60976"),
     *          @OA\Property(property="created_at", type="string", format="date-time", example="2020-01-01 00:00:00"),
     *          @OA\Property(property="updated_at", type="string", format="date-time", example="2020-01-01 00:00:00"),
     *      ),
     *  ),
     * )
     */
    public function store($entity, $sessionData, $exercisesData, $executionData, $targetsData, $user = null)
    {
        try {
            DB::beginTransaction();

            $sessionData['entity_id'] = $entity->id;
            $sessionData['entity_type'] = get_class($entity);

            $exerciseSession = $this->exerciseSessionRepository->create($sessionData);
            $exerciseSession->targets()->sync($targetsData);

            if (isset($executionData['place_session'])) {
                $entityBase = get_class($entity) == Team::class ? $entity->club : $entity->scholarCenter;

                $store_place = $this->exerciseSessionPlaceRepository->create([
                    'place_session' => $executionData['place_session'],
                    'entity_id' => $entityBase->id,
                    'entity_type' => get_class($entityBase)
                ]);

                $executionData['exercise_session_place_id'] = $store_place->id;
            }

            $exerciseSession->exercise_session_details()->create($executionData);

            if (isset($exercisesData) && count($exercisesData) > 0) {
                foreach ($exercisesData as $exercise) {
                    $exercise['exercise_session_id'] =  $exerciseSession->id;
                    $exercise_create = $this->exerciseSessionsRelationsRepository->create($exercise);
    
                    if (isset($exercise['work_groups'])) {
                        $exercise_create->work_groups()->sync($exercise['work_groups']);
                    }
                }
            }

            if ($user) {
                event(
                    new ActivityEvent(
                        $user,
                        $exerciseSession->entity->club,
                        'exercise_session_created',
                        get_class($entity) == Team::class ? $exerciseSession->entity : null
                    )
                );
            }
            
            DB::commit();
            return $exerciseSession;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Shows up information of an existing exercise session
     * @return ExerciseSession
     *
     * @OA\Schema(
     *  schema="ShowExerciseSessionResponse",
     *  type="object",
     *  description="Returns information about existent exercise session item",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Show single exercise session item"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="code", type="string", example="string"),
     *      @OA\Property(property="author", type="string", example="string"),
     *      @OA\Property(property="title", type="string", example="string"),
     *      @OA\Property(property="icon", type="string", example="string"),
     *      @OA\Property(property="difficulty", type="int64", example="1"),
     *      @OA\Property(property="intensity", type="int64", example="1"),
     *      @OA\Property(property="duration", type="string", example="30:25"),
     *      @OA\Property(property="number_exercises", type="int64", example="1"),
     *      @OA\Property(property="materials", type="string", example="string"),
     *      @OA\Property(property="type_exercise_session_id", type="int64", example="1"),
     *      @OA\Property(property="training_period_id", type="int64", example="1"),
     *      @OA\Property(property="entity_type", type="string", example="string"),
     *      @OA\Property(property="entity_id", type="int64", example="1"),
     *      @OA\Property(
     *          property="type_exercise_session",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="training_period",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="targets",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *      ),
     *      @OA\Property(
     *          property="exercise_session_exercises",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(
     *                  property="exercise",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="title", type="string", example="sring"),
     *                  @OA\Property(property="description", type="string", example="sring"),
     *                  @OA\Property(property="intensity", type="int64", example="1"),
     *                  @OA\Property(property="difficulty", type="int64", example="1"),
     *                  @OA\Property(property="user_id", type="int64", example="1"),
     *                  @OA\Property(property="resource_id", type="int64", example="1"),
     *                  @OA\Property(property="thumbnail", type="string", example="string"),
     *                  @OA\Property(property="resource", type="string", example="string"),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function show($code)
    {
        try {
            $sessionExercises = $this->exerciseSessionRepository->findExerciseSessionById($code);
            
            $sessionExercises->like = $this->getLike($sessionExercises->id);

            $exerciseSessionExercises = $sessionExercises->exercise_session_exercises;
            
            $contents = [];
            $targets = [];
            $contentBlocks = [];

            $isTeam = $sessionExercises->entity_type == Team::class;

            foreach ($exerciseSessionExercises as $exerciseSessionExercise) {
                if ($isTeam) {
                    $contentsExercise = $exerciseSessionExercise->exercise->contents ?? null;
                    
                    $contents = $this->mergeElementsExerciseSessionExercises($contentsExercise, $contents);

                    $targetsExercise = $exerciseSessionExercise->exercise->targets ?? null;

                    $targets = $this->mergeElementsExerciseSessionExercises($targetsExercise, $targets);
                } else {
                    $contentBlocksExercise = $exerciseSessionExercise->exercise->contentBlocks ?? null;

                    $contentBlocks = $this->mergeElementsExerciseSessionExercises($contentBlocksExercise, $contentBlocks);
                }
            }

            if ($isTeam) {
                $sessionExercises->contents = $this->helper->filterUniqueArray($contents);

                $sessionExercises->targets_groups = $this->helper->filterUniqueArray($targets);
            } else {
                $sessionExercises->content_blocks = $this->helper->filterUniqueArray($contentBlocks);
            }
            
            return $sessionExercises;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Updates an existing exercise session item
     * @return boolean
     *
     * @OA\Schema(
     *  schema="UpdateExerciseSessionResponse",
     *  type="object",
     *  description="Updates an existent exercise session item",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise session updated"),
     *  @OA\Property(property="data", type="boolean", example="true"),
     * )
     */
    public function update($entity, $code, $sessionData, $executionData, $targetsData, $user = null)
    {
        try {
            DB::beginTransaction();

            $session = $this->findSessionByCode($code);
            
            $session->targets()->sync($targetsData);
            
            if (isset($executionData['place_session'])) {
                $entityBase = get_class($entity) == Team::class ? $entity->club : $entity->scholarCenter;

                $store_place = $this->exerciseSessionPlaceRepository->create([
                    'place_session' => $executionData['place_session'],
                    'entity_id' => $entityBase->id,
                    'entity_type' => get_class($entityBase)
                ]);

                $executionData['exercise_session_place_id'] = $store_place->id;
            }

            $session->exercise_session_execution()->update($executionData);

            $update = $this->exerciseSessionRepository->update($sessionData, $session);

            if ($user) {
                event(
                    new ActivityEvent(
                        $user,
                        $session->entity->club,
                        'exercise_session_updated',
                        get_class($entity) == Team::class ? $session->entity : null
                    )
                );
            }

            DB::commit();

            return $update;
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }

    /**
     * Deletes an exercise session item from database
     * @return boolean
     *
     * @OA\Schema(
     *  schema="DeleteExerciseSessionResponse",
     *  type="object",
     *  description="Deletes an existent exercise session item",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise session deleted"),
     *  @OA\Property(property="data", type="boolean", example="true"),
     * )
     */
    public function delete($entity, $code, $user = null)
    {
        try {
            $session = $this->findSessionByCode($code);

            if ($user) {
                event(
                    new ActivityEvent(
                        $user,
                        $session->entity->club,
                        'exercise_session_deleted',
                        get_class($entity) == Team::class ? $session->entity : null
                    )
                );
            }

            return $this->exerciseSessionRepository->delete($session->id);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Used to manually search a session item in database by it's code
     * @return object
     */
    private function findSessionByCode($code)
    {
        $session = $this->exerciseSessionRepository->findOneBy([
            'code' => $code
        ]);

        if (!$session) {
            return new Exception('Exercise session not found');
        }

        return $session;
    }


    /**
     * This function is called when the user clicks on the button to download the PDF.
     *
     * @param code the id of the exercise session
     */
    public function loadPdf($code)
    {
        return $this->exerciseSessionRepository->findExerciseSessionById($code);
    }

    /**
     * This function checks if a user has liked an exercise session.
     *
     * @param exercise_session_id The ID of the exercise session for which we want to check if the
     * authenticated user has liked it or not.
     *
     * @return a boolean value, `true` if a like exists for the given exercise session ID and user ID,
     * and `false` otherwise.
     */
    private function getLike($exercise_session_id)
    {
        $existLike = $this->likeEntityRepository->findOneBy([
            'entity_type' => ExerciseSession::class,
            'entity_id' => $exercise_session_id,
            'user_id' => Auth::id()
        ]);

        return $existLike ? true : false;
    }

    /**
     * This function filters out exercises from a given array that have IDs matching those in another
     * given array.
     *
     * @param exercises An array of exercise objects.
     * @param exercises_id An array of exercise IDs that need to be filtered out from the
     * array.
     *
     * @return an array of exercises that are not in the given array of exercise IDs.
     */
    private function filterExerciseInSession($exercises, $exercises_id)
    {
        $exercises_filter = [];

        foreach ($exercises as $exercise) {
            if (!in_array($exercise->id, $exercises_id)) {
                array_push($exercises_filter, $exercise);
            }
        }

        return $exercises_filter;
    }

    /**
     * This function merges two arrays in PHP.
     *
     * @param arrayElements It is a parameter that represents an array of elements that need to be
     * merged with another array.
     * @param elements The variable  is an array that contains elements to be merged with
     * another array.
     *
     * @return the merged array of  and .
     */
    private function mergeElementsExerciseSessionExercises($arrayElements, $elements)
    {
        foreach($arrayElements as $element) {
            $key = array_search($element->id, array_column($elements, 'id'));
            
            if(is_integer($key)) { continue; }

            array_push($elements, $element);
        }

        return $elements;
    }
}
