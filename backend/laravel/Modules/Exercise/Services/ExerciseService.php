<?php

namespace Modules\Exercise\Services;

use Exception;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Team\Services\TeamService;
use Modules\Exercise\Entities\Exercise;
use Modules\Classroom\Entities\Classroom;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\LikeEntityRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseEntityRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseTargetSessionRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseContentRelationRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseContentBlockRelationRepositoryInterface;

class ExerciseService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var object $teamRepository
     */
    protected $teamRepository;

    /**
     * @var object $exerciseRepository
     */
    protected $exerciseRepository;

    /**
     * @var object $exerciseEntityRepository
     */
    protected $exerciseEntityRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $contentRelationRepository
     */
    protected $contentRelationRepository;

    /**
     * @var $contentBlockRelationRepository
     */
    protected $contentBlockRelationRepository;
    
    /**
     * @var $targetSessionRepository
     */
    protected $targetSessionRepository;
    
    /**
     * @var object $likeEntityRepository
     */
    protected $likeEntityRepository;
    
    /**
     * @var $teamService
     */
    protected $teamService;

    /**
     * Create a new service instance
     */
    public function __construct(
        TeamRepositoryInterface $teamRepository,
        ExerciseRepositoryInterface $exerciseRepository,
        ResourceRepositoryInterface $resourceRepository,
        ExerciseEntityRepositoryInterface $exerciseEntityRepository,
        ExerciseContentRelationRepositoryInterface $contentRelationRepository,
        ExerciseContentBlockRelationRepositoryInterface $contentBlockRelationRepository,
        ExerciseTargetSessionRepositoryInterface $targetSessionRepository,
        LikeEntityRepositoryInterface $likeEntityRepository,
        TeamService $teamService
    ) {
        $this->teamRepository = $teamRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->resourceRepository = $resourceRepository;
        $this->exerciseEntityRepository = $exerciseEntityRepository;
        $this->contentRelationRepository = $contentRelationRepository;
        $this->contentBlockRelationRepository = $contentBlockRelationRepository;
        $this->targetSessionRepository = $targetSessionRepository;
        $this->likeEntityRepository = $likeEntityRepository;
        $this->teamService = $teamService;
    }

    /**
     * List entities to exercise
     *
     * @param $exercise_id
     * @param $entity
     * @param $entity_ids
     */
    public function listEntitiesByExercise($exercise_id, $type = 'sport')
    {
        try {
            $exercise = $this->exerciseRepository->findOneBy(['id' => $exercise_id]);
            
            if ($type == 'sport') {
                foreach ($exercise->teams as $team) {
                    $team->makeHidden(['type', 'sport', 'season', 'pivot', 'created_at', 'deleted_at','season_id']);
                };
    
                return $exercise->teams;
            } else {
                return $exercise->classrooms;
            }
            
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Add entities to exercise
     *
     * @param $exercise_id
     * @param $entity
     * @param $entity_ids
     */
    public function updateEntitiesToExercise($exercise_id, $entity, $entity_ids)
    {
        try {
            DB::beginTransaction();

            $exercise = $this->exerciseRepository->findOneBy(['id' => $exercise_id]);

            $this->exerciseEntityRepository->deleteByCriteria([
                'entity_type' => $entity,
                'exercise_id' => $exercise_id
            ]);

            $exercise->exerciseEntities()->attach($entity_ids, ['entity_type' => $entity]);
            
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception;
        }

        return true;
    }

    /**
     * Retrieves a list of exercises related to the entity sent
     * @return array
     *
     * @OA\Schema(
     *  schema="ListTeamExerciseResponse",
     *  type="object",
     *  description="Returns the list of team exercises",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of team exercises"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="title", type="string", example="string"),
     *          @OA\Property(property="description", type="string", example="string"),
     *          @OA\Property(property="favorite", type="boolean", example="false"),
     *          @OA\Property(property="dimentions", type="string", example="string"),
     *          @OA\Property(property="duration", type="string", example="string"),
     *          @OA\Property(property="repetitions", type="int64", example="1"),
     *          @OA\Property(property="duration_repetitions", type="string", example="string"),
     *          @OA\Property(property="break_repetitions", type="string", example="string"),
     *          @OA\Property(property="series", type="int64", example="1"),
     *          @OA\Property(property="break_series", type="string", example="string"),
     *          @OA\Property(property="difficulty", type="int64", example="1"),
     *          @OA\Property(property="intensity", type="int64", example="1"),
     *          @OA\Property(property="thumbnail", type="string", example="string"),
     *          @OA\Property(property="3d", type="string", example="string"),
     *          @OA\Property(property="distribution_exercise_id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="resource_id", type="int64", example="1"),
     *          @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
     *          @OA\Property(property="resource", type="string", example="string"),
     *          @OA\Property(
     *              property="distribution",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="contents",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="1"),
     *                  @OA\Property(property="image_id", type="int64", example="1"),
     *                  @OA\Property(property="image_url", type="string", example="string"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     *
     * @OA\Schema(
     *  schema="ListClassroomExerciseResponse",
     *  type="object",
     *  description="Returns the list of classroom exercises",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of classroom exercises"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="title", type="string", example="string"),
     *          @OA\Property(property="description", type="string", example="string"),
     *          @OA\Property(property="favorite", type="boolean", example="false"),
     *          @OA\Property(property="dimentions", type="string", example="string"),
     *          @OA\Property(property="duration", type="string", example="string"),
     *          @OA\Property(property="repetitions", type="int64", example="1"),
     *          @OA\Property(property="duration_repetitions", type="string", example="string"),
     *          @OA\Property(property="break_repetitions", type="string", example="string"),
     *          @OA\Property(property="series", type="int64", example="1"),
     *          @OA\Property(property="break_series", type="string", example="string"),
     *          @OA\Property(property="difficulty", type="int64", example="1"),
     *          @OA\Property(property="intensity", type="int64", example="1"),
     *          @OA\Property(property="thumbnail", type="string", example="string"),
     *          @OA\Property(property="3d", type="string", example="string"),
     *          @OA\Property(property="distribution_exercise_id", type="int64", example="1"),
     *          @OA\Property(property="exercise_education_level_id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="resource_id", type="int64", example="1"),
     *          @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
     *          @OA\Property(property="resource", type="string", example="string"),
     *          @OA\Property(
     *              property="distribution",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="content_blocks",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *          ),
     *          @OA\Property(
     *              property="exercise_education_level",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function list($requestParams, $entity)
    {
        try {
            $exercises = $this->exerciseRepository->findByEntity($requestParams, $entity);

            foreach ($exercises as $exercise) {
                $exercise->like = $this->getLike($exercise->id);
            }

            return $exercises;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieve list of exercise by user
     */
    public function listByUser($user_id, $filters = [])
    {
        $exercises = $this->exerciseRepository->listByUserWithFilters($user_id, $filters);

        $exercises->map(function($exercise) {
            $exercise->makeHidden('3d');

            $exercise->entity->entity_type == Team::class ?
                $exercise->teams :
                $exercise->classrooms;
        });

        return $exercises;
    }

    /**
     * Stores and returns a new stored exercise
     * @return Exercise
     *
     * @OA\Schema(
     *  schema="StoreTeamExerciseResponse",
     *  type="object",
     *  description="Returns the recently stored team exercise",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise stored"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="entity_type", type="string", example="string"),
     *      @OA\Property(property="entity_id", type="int64", example="1"),
     *      @OA\Property(property="code", type="string", example="string"),
     *      @OA\Property(property="title", type="string", example="string"),
     *      @OA\Property(property="description", type="string", example="string"),
     *      @OA\Property(property="favorite", type="boolean", example="false"),
     *      @OA\Property(property="dimentions", type="string", example="string"),
     *      @OA\Property(property="duration", type="string", example="string"),
     *      @OA\Property(property="repetitions", type="int64", example="1"),
     *      @OA\Property(property="duration_repetitions", type="string", example="string"),
     *      @OA\Property(property="break_repetitions", type="string", example="string"),
     *      @OA\Property(property="series", type="int64", example="1"),
     *      @OA\Property(property="break_series", type="string", example="string"),
     *      @OA\Property(property="difficulty", type="int64", example="1"),
     *      @OA\Property(property="intensity", type="int64", example="1"),
     *      @OA\Property(property="thumbnail", type="string", example="string"),
     *      @OA\Property(property="3d", type="string", example="string"),
     *      @OA\Property(property="distribution_exercise_id", type="int64", example="1"),
     *      @OA\Property(property="user_id", type="int64", example="1"),
     *      @OA\Property(property="resource_id", type="int64", example="1"),
     *      @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
     *      @OA\Property(property="updated_at", type="date-time", example="2022-01-01 00:00:00"),
     *  ),
     * )
     *
     * @OA\Schema(
     *  schema="StoreClassroomExerciseResponse",
     *  type="object",
     *  description="Returns the recently stored classroom exercise",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise stored"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="entity_type", type="string", example="string"),
     *      @OA\Property(property="entity_id", type="int64", example="1"),
     *      @OA\Property(property="code", type="string", example="string"),
     *      @OA\Property(property="title", type="string", example="string"),
     *      @OA\Property(property="description", type="string", example="string"),
     *      @OA\Property(property="favorite", type="boolean", example="false"),
     *      @OA\Property(property="dimentions", type="string", example="string"),
     *      @OA\Property(property="duration", type="string", example="string"),
     *      @OA\Property(property="repetitions", type="int64", example="1"),
     *      @OA\Property(property="duration_repetitions", type="string", example="string"),
     *      @OA\Property(property="break_repetitions", type="string", example="string"),
     *      @OA\Property(property="series", type="int64", example="1"),
     *      @OA\Property(property="break_series", type="string", example="string"),
     *      @OA\Property(property="difficulty", type="int64", example="1"),
     *      @OA\Property(property="intensity", type="int64", example="1"),
     *      @OA\Property(property="thumbnail", type="string", example="string"),
     *      @OA\Property(property="3d", type="string", example="string"),
     *      @OA\Property(property="distribution_exercise_id", type="int64", example="1"),
     *      @OA\Property(property="exercise_education_level_id", type="int64", example="1"),
     *      @OA\Property(property="user_id", type="int64", example="1"),
     *      @OA\Property(property="resource_id", type="int64", example="1"),
     *      @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
     *      @OA\Property(property="updated_at", type="date-time", example="2022-01-01 00:00:00"),
     *  ),
     * )
     */
    public function store($requestData, $userId, $entity = null)
    {
        try {
            $requestData['user_id'] = $userId;

            if (!isset($requestData['sport_id'])) {
                $requestData['sport_id'] = $entity->sport_id ?? null;
            }

            $exercise = $this->exerciseRepository->create($requestData);

            if ($entity) {
                $exercise->exerciseEntities()->attach($entity->id, ['entity_type' => get_class($entity)]);
            }

            if (isset($requestData['content_exercise_ids'])) {
                $this->handleContentRelations($exercise->id, $requestData['content_exercise_ids']);
            }

            if (isset($requestData['content_block_ids'])) {
                $this->handleContentBlockRelations($exercise->id, $requestData['content_block_ids']);
            }
            
            if (isset($requestData['target_ids'])) {
                $this->handleTargetRelations($exercise->id, $requestData['target_ids']);
            }

            return $exercise;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves a exercise with respecitve items depending on the related entity class
     * @return array
     *
     * @OA\Schema(
     *  schema="ShowTeamExerciseResponse",
     *  type="object",
     *  description="Returns the team exercise depending on the given code",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise detail"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="title", type="string", example="string"),
     *          @OA\Property(property="description", type="string", example="string"),
     *          @OA\Property(property="favorite", type="boolean", example="false"),
     *          @OA\Property(property="dimentions", type="string", example="string"),
     *          @OA\Property(property="duration", type="string", example="string"),
     *          @OA\Property(property="repetitions", type="int64", example="1"),
     *          @OA\Property(property="duration_repetitions", type="string", example="string"),
     *          @OA\Property(property="break_repetitions", type="string", example="string"),
     *          @OA\Property(property="series", type="int64", example="1"),
     *          @OA\Property(property="break_series", type="string", example="string"),
     *          @OA\Property(property="difficulty", type="int64", example="1"),
     *          @OA\Property(property="intensity", type="int64", example="1"),
     *          @OA\Property(property="thumbnail", type="string", example="string"),
     *          @OA\Property(property="3d", type="string", example="string"),
     *          @OA\Property(property="distribution_exercise_id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="resource_id", type="int64", example="1"),
     *          @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
     *          @OA\Property(property="resource", type="string", example="string"),
     *          @OA\Property(
     *              property="distribution",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="contents",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="1"),
     *                  @OA\Property(property="image_id", type="int64", example="1"),
     *                  @OA\Property(property="image_url", type="string", example="string"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *          ),
     *          @OA\Property(
     *              property="entity",
     *              type="object",
     *              ref="#/components/schemas/TeamSchema",
     *          ),
     *      ),
     *  ),
     * )
     *
     * @OA\Schema(
     *  schema="ShowClassroomExerciseResponse",
     *  type="object",
     *  description="Returns the classroom exercise depending on the given code",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise detail"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="title", type="string", example="string"),
     *          @OA\Property(property="description", type="string", example="string"),
     *          @OA\Property(property="favorite", type="boolean", example="false"),
     *          @OA\Property(property="dimentions", type="string", example="string"),
     *          @OA\Property(property="duration", type="string", example="string"),
     *          @OA\Property(property="repetitions", type="int64", example="1"),
     *          @OA\Property(property="duration_repetitions", type="string", example="string"),
     *          @OA\Property(property="break_repetitions", type="string", example="string"),
     *          @OA\Property(property="series", type="int64", example="1"),
     *          @OA\Property(property="break_series", type="string", example="string"),
     *          @OA\Property(property="difficulty", type="int64", example="1"),
     *          @OA\Property(property="intensity", type="int64", example="1"),
     *          @OA\Property(property="thumbnail", type="string", example="string"),
     *          @OA\Property(property="3d", type="string", example="string"),
     *          @OA\Property(property="distribution_exercise_id", type="int64", example="1"),
     *          @OA\Property(property="exercise_education_level_id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="resource_id", type="int64", example="1"),
     *          @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
     *          @OA\Property(property="resource", type="string", example="string"),
     *          @OA\Property(
     *              property="distribution",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="content_blocks",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *          ),
     *          @OA\Property(
     *              property="entity",
     *              type="object",
     *              ref="#/components/schemas/Classroom",
     *          ),
     *          @OA\Property(
     *              property="exercise_education_level",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function show($code)
    {
        try {
            $exercise = $this->findExercise($code);
            $exercise->entity;
            $exercise->user;
            $exercise->sport;
            $exercise->intensityRelation;
            $exercise->like = $this->getLike($exercise->id);
            
            if ($exercise->entity->entity_type == Team::class) {
                $exercise->contents;
                $exercise->teams;
                $exercise->targets;
            } elseif ($exercise->entity->entity_type == Classroom::class) {
                $exercise->contentBlocks;
                $exercise->exerciseEducationLevel;
                $exercise->classrooms;
            }
    
            return $exercise;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves a exercise with respecitve items depending on the related entity class
     * @return array
     *
     * @OA\Schema(
     *  schema="UpdateExerciseResponse",
     *  type="object",
     *  description="Returns the team exercise depending on the given code",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise updated"),
     *  @OA\Property(
     *      property="data",
     *      type="boolean",
     *      example="true"
     *  ),
     * )
     */
    public function update($requestData, $code)
    {
        try {
            $exercise = $this->findExercise($code);

            if (isset($requestData['content_exercise_ids'])) {
                $this->handleContentRelations($exercise->id, $requestData['content_exercise_ids'], 'update');
            }

            if (isset($requestData['content_block_ids'])) {
                $this->handleContentBlockRelations($exercise->id, $requestData['content_block_ids'], 'update');
            }

            if (isset($requestData['target_ids'])) {
                $this->handleTargetRelations($exercise->id, $requestData['target_ids'], 'update');
            }

            return $this->exerciseRepository->update($requestData, $exercise);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes an existent exercise by its code
     * @return array
     *
     * @OA\Schema(
     *  schema="DeleteExerciseResponse",
     *  type="object",
     *  description="Returns the team exercise depending on the given code",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise deleted"),
     *  @OA\Property(
     *      property="data",
     *      type="boolean",
     *      example="true"
     *  ),
     * )
     */
    public function delete($code)
    {
        try {
            $exercise = $this->findExercise($code);

            return $this->exerciseRepository->delete($exercise->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     *
     */
    private function findExercise($code)
    {
        $exercise = $this->exerciseRepository->findOneBy([
            'code' => $code
        ]);

        if (!$exercise) {
            throw new Exception('Exercise not found', Response::HTTP_NOT_FOUND);
        }

        return $exercise;
    }

    /**
     * Stores and manages internal single content relations for exercise
     *
     * @param int $exerciseId
     * @param int[] $contentIds
     * @param string $action
     * @return void
     */
    private function handleContentRelations($exerciseId, $contentIds, $action = 'create')
    {
        if ($action == 'update') {
            $this->contentRelationRepository->deleteByCriteria([
                'exercise_id' => $exerciseId,
            ]);
        }

        foreach ($contentIds as $contentId) {
            $this->contentRelationRepository->create([
                'exercise_id' => $exerciseId,
                'content_exercise_id' => $contentId,
            ]);
        }
    }

    /**
     * Stores and manages internal single content relations for exercise
     *
     * @param int $exerciseId
     * @param int[] $contentBlockIds
     * @param string $action
     * @return void
     */
    private function handleContentBlockRelations($exerciseId, $contentBlockIds, $action = 'create')
    {
        if ($action == 'update') {
            $this->contentBlockRelationRepository->deleteByCriteria([
                'exercise_id' => $exerciseId,
            ]);
        }

        foreach ($contentBlockIds as $contentId) {
            $this->contentBlockRelationRepository->create([
                'exercise_id' => $exerciseId,
                'exercise_content_block_id' => $contentId,
            ]);
        }
    }

    /**
     * Stores and manages internal single target session relations for exercise
     *
     * @param int $exerciseId
     * @param int[] $targetIds
     * @param string $action
     * @return void
     */
    private function handleTargetRelations($exerciseId, $targetIds, $action = 'create')
    {
        if ($action == 'update') {
            $this->targetSessionRepository->deleteByCriteria([
                'exercise_id' => $exerciseId,
            ]);
        }

        foreach ($targetIds as $targetId) {
            $this->targetSessionRepository->create([
                'exercise_id' => $exerciseId,
                'target_session_id' => $targetId,
            ]);
        }
    }

    /**
     * This function checks if a user has liked a specific exercise.
     *
     * @param exercise_id The ID of the exercise entity for which we want to check if the authenticated
     * user has liked it or not.
     *
     * @return a boolean value, true if the user has already liked the exercise with the given ID, and
     * false otherwise.
     */
    private function getLike($exercise_id)
    {
        $existLike = $this->likeEntityRepository->findOneBy([
            'entity_type' => Exercise::class,
            'entity_id' => $exercise_id,
            'user_id' => Auth::id()
        ]);

        return $existLike ? true : false;
    }
}
