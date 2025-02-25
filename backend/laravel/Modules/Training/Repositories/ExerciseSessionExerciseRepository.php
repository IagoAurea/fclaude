<?php

namespace Modules\Training\Repositories;

use Exception;
use App\Services\ModelRepository;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\DB;
use Modules\Training\Entities\ExerciseSessionExercise;
use Modules\Training\Repositories\Interfaces\ExerciseSessionExerciseRepositoryInterface;


class ExerciseSessionExerciseRepository extends ModelRepository implements ExerciseSessionExerciseRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'exercise_session_exercises';


    /**
     * @var object
    */
    protected $model;

    /**
     * @var $exercisesSessionDetailRepository
    */
    protected $exercisesSessionDetailRepository;

    public function __construct(
        ExerciseSessionExercise $model
    )
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    /**
     * Public function to adding exercise to session exercise
     *
     * @return Object
     */

    public function createExerciseSessionExercise($request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->exercises as $exercise) {
                $exercise['exercise_session_id'] =  $request->exercise_session_id;
                $exerciseSessionExercise = $this->create($exercise);
                $exerciseSessionExercise->work_groups()->sync($exercise['work_groups']);
            }
            
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }

        return $exerciseSessionExercise;
    }

    /**
     * Public function to retrieve Exercise Session model and its relationships
     *
     * @return Object
     */

    public function findExerciseSessionExerciseByCode($code)
    {
        $exerciseSessionExercise = $this->model
            ->with('work_groups')
            ->with('exercise', function ($query) {
                $query->with('targets', 'contents',
                    'intensityRelation', 'image', 'contentBlocks',
                    'exerciseEducationLevel', 'distribution'
                );
            })
            ->where('code', $code)
            ->first();

        if (!$exerciseSessionExercise) {
            throw new Exception("Exercises  not found");
        }
        
        return $exerciseSessionExercise;
    }

    /**
     * Public function to retrieve List of  Exercise   By search
     *
     * @return Array
     */

    public function searchExercises($exercise_session_code, $search, $order)
    {
        $conditionsWhere = [];
        $conditionsOrWhere = [];
        
        if (is_null($search)) {
            $order = 'asc';
        }

        if (!is_null($search) && trim($search) != "") {
            $conditionsWhere[] = [DB::raw('LOWER(exercises.title)'), 'LIKE', '%' . strtolower($search) . '%'];
            $conditionsOrWhere[] = [DB::raw('LOWER(exercises.description)'), 'LIKE', '%' . strtolower($search) . '%'];
        }

        return $this->model
                ->whereHas('exercise', function (Builder $query) use ($conditionsWhere,$conditionsOrWhere) {
                    $query->where($conditionsWhere)
                    ->orWhere($conditionsOrWhere)
                    ->with(['resource']);
                })
                ->whereHas('exercise_session', function (Builder $query) use ($exercise_session_code) {
                    $query->where("code",$exercise_session_code);
                })
                ->with(['work_groups','exercise'])
                ->orderBy('exercise_session_exercises.created_at',$order)
                ->get();
    }

}