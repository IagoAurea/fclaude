<?php

namespace Modules\Exercise\Repositories;

use Modules\Team\Entities\Team;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Exercise\Entities\Exercise;
use Modules\Classroom\Entities\Classroom;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;

class ExerciseRepository extends ModelRepository implements ExerciseRepositoryInterface
{
	/**
     * @var object
     */
    protected $model;

    public function __construct(Exercise $model)
    {
        $this->model = $model;
        parent::__construct($this->model, ['resource', 'distribution', 'content']);
    }

    /**
     * Retrieve list exercise by user and filter sport, title and description
     */
    public function listByUserWithFilters(int $userId, array $filters)
    {
        $query = $this->model
            ->with('sport', 'distribution', 'contents', 'contentBlocks', 'exerciseEducationLevel')
            ->where('user_id', $userId)
            ->when(isset($filters['name']), function ($query) use ($filters) {
                return $query->where('title', 'ilike', '%'.$filters['name'].'%')
                    ->orWhere('description', 'ilike', '%'.$filters['name'].'%');
            })
            ->when(isset($filters['sport']), function ($query) use ($filters) {
                return $query->whereHas('sport', function($q) use($filters) {
                    $q->where('code', $filters['sport']);
                });
            });

        return $query->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Find exercise by team
     */
    public function findByTeamFilterAndOrder($team, $params = [])
    {
        return $this->findBy([
            'team_id' => $team
        ]);
    }

    /**
     * Builds the database query via model and it goes adding more
     * parameters and filterting depending on the query parameters sent
     *
     * @param array|object $requestParams
     * @param Classroom|Team $entity
     *
     * @return array
     */
    public function findByEntity($requestParams, $entity)
    {
        $classType = get_class($entity);

        $query = $this->model
            ->select(
                'id','code', 'title', 'description', 'duration', 'difficulty', 'intensity',
                'distribution_exercise_id', 'exercise_education_level_id', 'user_id',
                'thumbnail', 'repetitions', 'break_repetitions', 'break_series',
                'sport_id', 'image_id', 'created_at'
            )
            ->whereHas('entity', function ($query) use ($entity) {
                $query->where('entity_id', $entity->id)
                    ->where('entity_type', get_class($entity));
            })
            ->with('distribution', 'entity')
            ->with(['user' => function ($query) {
                $query->select('id','full_name');
            }])
            ->with(['sport' => function ($query) {
                $query->select('id', 'model_url', 'image_exercise_id');
            }]);

        if ($classType == Team::class) {
            $query->with('contents');
        } elseif ($classType == Classroom::class) {
            $query->with('contentBlocks', 'exerciseEducationLevel');
        }

        if (isset($requestParams['distribution_exercise_id'])) {
            $query->where('distribution_exercise_id', $requestParams['distribution_exercise_id']);
        }

        if (isset($requestParams['difficulty'])) {
            $query->where('difficulty', $requestParams['difficulty']);
        }

        if (isset($requestParams['intensity'])) {
            $query->where('intensity', $requestParams['intensity']);
        }

        if (isset($requestParams['user_id'])) {
            $query->where('user_id', $requestParams['user_id']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
