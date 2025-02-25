<?php

namespace Modules\Training\Repositories;

use Exception;
use App\Services\ModelRepository;
use Modules\Alumn\Entities\Alumn;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Training\Entities\ExerciseSession;
use Modules\Training\Entities\ExerciseSessionExercise;
use Modules\Training\Repositories\Interfaces\ExerciseSessionRepositoryInterface;

class ExerciseSessionRepository extends ModelRepository implements ExerciseSessionRepositoryInterface
{

    const TEAM = 'Team';

    /**
     * @var string
    */
    protected $table = 'exercise_sessions';

    /**
     * @var object
    */
    protected $model;

    /**
     * @var $exercisesSessionDetailRepository
    */
    protected $exercisesSessionDetailRepository;

    public function __construct(ExerciseSession $model) {
        $this->model = $model;
        parent::__construct($this->model);
    }

    /**
     * Retrieve all assistances by session
     */
    public function findAllAssistancesBySession($code, $academic_year_id)
    {
        $exerciseSession = $this->findOneBy(['code' => $code]);

        $url_image = config('resource.url');

        if (class_basename($exerciseSession->entity_type) == self::TEAM) {
            $query = DB::table('players')
                ->select('players.id', 'players.full_name',
                    'players.shirt_number',
                    'exercise_session_assistances.assistance',
                    'exercise_session_assistances.created_at',
                    'exercise_session_assistances.perception_effort_id',
                    DB::raw('resources.url as percept_effort_url'),
                    DB::raw('subjec_percept_efforts.number as percept_number'),
                    DB::raw('subjec_percept_effort_translations.name as percept_name')
                )
                ->leftJoin('exercise_session_assistances', function ($join) use ($exerciseSession) {
                    $join->on('players.id', '=', 'exercise_session_assistances.applicant_id')
                        ->where('exercise_session_assistances.applicant_type', Player::class)
                        ->where('exercise_session_assistances.exercise_session_id', $exerciseSession->id);
                    }
                )
                ->leftJoin('subjec_percept_efforts',
                    'exercise_session_assistances.perception_effort_id', '=', 'subjec_percept_efforts.id'
                )
                ->leftJoin('subjec_percept_effort_translations', function ($join) {
                    $join->on('subjec_percept_efforts.id', '=', 'subjec_percept_effort_translations.subjec_percept_effort_id')
                        ->where('subjec_percept_effort_translations.locale', app()->getLocale());
                    }
                )
                ->leftJoin('resources',
                    'subjec_percept_efforts.image_id', '=', 'resources.id'
                )
                ->where('players.team_id', $exerciseSession->entity_id)
                ->whereNull('players.deleted_at');
        } else {
            $query = DB::table('alumns')
                ->select('alumns.id as alumn_id', 'alumns.full_name',
                    // 'exercise_session_assistances.assistance',
                    // 'exercise_session_assistances.perception_effort_id',
                    // DB::raw('resources.url as percept_effort_url'),
                    // DB::raw('subjec_percept_efforts.number as percept_number'),
                    // DB::raw('subjec_percept_effort_translations.name as percept_name')
                )
                ->join('classroom_academic_year_alumns',
                    'alumns.id', '=', 'classroom_academic_year_alumns.alumn_id'
                )
                ->join('classroom_academic_years',
                    'classroom_academic_year_alumns.classroom_academic_year_id', '=',
                    'classroom_academic_years.academic_year_id'
                )
                ->leftJoin('academic_years',
                    'classroom_academic_years.academic_year_id', '=',
                    'academic_years.id'
                )
                // ->leftJoin('exercise_session_assistances', function ($join) use ($exerciseSession) {
                //     $join->on('alumns.id', '=', 'exercise_session_assistances.applicant_id')
                //         ->where('exercise_session_assistances.applicant_type', Alumn::class)
                //         ->where('exercise_session_assistances.exercise_session_id', $exerciseSession->id);
                //     }
                // )
                // ->leftJoin('subjec_percept_efforts',
                //     'exercise_session_assistances.perception_effort_id', '=', 'subjec_percept_efforts.id'
                // )
                // ->leftJoin('subjec_percept_effort_translations', function ($join) {
                //     $join->on('subjec_percept_efforts.id', '=', 'subjec_percept_effort_translations.subjec_percept_effort_id')
                //         ->where('subjec_percept_effort_translations.locale', app()->getLocale());
                //     }
                // )
                // ->leftJoin('resources',
                //     'subjec_percept_efforts.image_id', '=', 'resources.id'
                // )
                ->where('classroom_academic_years.classroom_id', $exerciseSession->entity_id)
                // ->where('academic_years.id', $academic_year_id)
                ->whereNull('alumns.deleted_at');
        }

        return $query->get();
    }

    /**
     * Public function to make the insert in the Exercise Session model and its relationships
     *
     * @return Object
     */

    public function createExerciseSession($request)
    {
        DB::beginTransaction();
        try {
            $exerciseSession = $this->create($request->except('exercises', 'execution', 'targets'));
            $exerciseSession->targets()->sync($request->targets);
            $exerciseSession->exercise_session_details()->create($request->execution);

            foreach ($request->exercises as $exercise) {
                $exercise['exercise_session_id'] =  $exerciseSession->id;
                $exercise_save = New ExerciseSessionExercise;
                $exercise_create = $exercise_save->create($exercise);
                $exercise_create->work_groups()->sync($exercise['work_groups']);
            }
            
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
        return $exerciseSession;
    }

    /**
     * Public function to make the insert in the Exercise Session model and its relationships
     *
     * @return Object
     */

    public function updateExerciseSession($request, $code)
    {
        DB::beginTransaction();
        try {

            $exerciseSession = $this->findOneBy(["code" => $code]);
            if (!$exerciseSession) {
                return new Exception("Exercises session not found");
            }

            $exerciseSession->targets()->sync($request->targets);
            $exerciseSession = $this->update($request->except('exercises','targets'),$exerciseSession);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
        return $exerciseSession;
    }

    /**
     * Public function to retrieve Exercise Session model and its relationships
     *
     * @return Object
     */

    public function findExerciseSessionById($code)
    {
        $relations = $this->getModelRelations();

        $exerciseSession = $this->model
            ->with($relations)
            ->where('code', $code)
            ->first();

        if (!$exerciseSession) {
            throw new Exception("Exercises session not found");
        }
        
        $exerciseSession->targets->makeHidden('pivot');
        $exerciseSession->makeHidden('type_exercise_session_id');
        $exerciseSession->makeHidden('training_period_id');
        $exerciseSession->exercise_session_exercises->makeHidden('exercise_id');
        $exerciseSession->exercise_session_exercises->makeHidden('exercise_session_id');

        return $exerciseSession;
    }

    /**
     * Public function to retrieve Exercise Session model List and its relationships
     *
     * @return Array
     */
    
    public function findAllExerciseSessionsByUserAndEntity($userId, $entity, $entityId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('entity_type', $entity)
            ->where('entity_id', $entityId)
            ->with(['exercises'=> function ($query) {
                $query->select('exercises.title', 'exercises.resource_id')
                ->with(['resource']);
            }])
            ->get();
    }

    /**
     * Public function to retrieve List of materials by Exercise Session
     *
     * @return Array
     */
    
    public function listOfMaterialsBySession($session_id)
    {
        return $this->model
        ->where('id', $session_id)
        ->with(['exercises'=> function ($query) {
            $query->select('exercises.title', 'exercises.resource_id')
            ->with(['resource']);},])
        ->get();
    }

    /**
     * Public function to retrieve List of  Exercise Session  By search
     *
     * @return Array
     */
    public function searchExerciseSessions($requestData, $entity)
    {
        $conditionsOrWhere = [];

        if (isset($requestData['search'])) {
            $searchString = strtolower($requestData['search']);

            $conditionsOrWhere[] = [
                DB::raw('LOWER(author)'), 'LIKE', '%' . $searchString . '%'
            ];

            $conditionsOrWhere[] = [
                DB::raw('LOWER(title)'), 'LIKE', '%' . $searchString . '%'
            ];

            $conditionsOrWhere[] = [
                DB::raw('LOWER(materials)'), 'LIKE', '%' . $searchString . '%'
            ];
        }

        $order = $requestData['order'] ?? 'desc';

        return $this->model
            ->where('entity_id', $entity->id)
            ->where('entity_type', get_class($entity))
            ->orWhere($conditionsOrWhere)
            ->with('exercise_session_execution')
            ->with(['exercise_session_exercises' => function ($query) {
                $query->with([
                    'exercise' => function ($query) {
                        $query->select(
                            'exercises.id',
                            'exercises.title',
                            'exercises.image_id',
                            'exercises.sport_id',
                        )->with(['sport' => function ($query) {
                            $query->select(
                                'sports.id',
                                'sports.image_id',
                                'sports.court_id',
                                'sports.image_exercise_id',
                            );
                        }]);
                    }
                ]);
            }])
            ->orderBy('exercise_sessions.order', $order)
            ->get();
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     *
     * @return Array
     */
    private function getModelRelations()
    {
        $locale = app()->getLocale();

        return [
            'exercise_session_details',
            'type_exercise_session' => function ($query) use ($locale) {
                $query->select('type_exercise_sessions.id')
                    ->withTranslation($locale);
            },
            'training_period' => function ($query) use ($locale) {
                $query->select('training_periods.id')
                    ->withTranslation($locale);
            },
            'targets' => function ($query) use ($locale) {
                $query->select('target_sessions.id')
                ->withTranslation($locale);
            },
            'exercise_session_exercises' => function ($query) {
                $query->select(
                    'exercise_session_exercises.id',
                    'exercise_session_exercises.code',
                    'exercise_session_exercises.duration',
                    'exercise_session_exercises.intensity',
                    'exercise_session_exercises.difficulty',
                    'exercise_session_exercises.exercise_session_id',
                    'exercise_session_exercises.exercise_id',
                    'exercise_session_exercises.order',
                )->with([
                    'exercise' => function ($query) {
                        $query->select(
                            'exercises.id',
                            'exercises.title',
                            'exercises.description',
                            'exercises.intensity',
                            'exercises.difficulty',
                            'exercises.user_id',
                            'exercises.image_id',
                            'exercises.sport_id',
                            'exercises.resource_id',
                            'exercises.thumbnail',
                            'exercises.exercise_education_level_id',
                        )->with(['resource', 'sport', 'contents', 'targets',
                            'contentBlocks', 'exerciseEducationLevel']);
                    },
                ])
                ->orderBy('exercise_session_exercises.order', 'ASC');
            },
        ];
    }
}
