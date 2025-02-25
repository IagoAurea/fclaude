<?php

namespace Modules\Training\Repositories;

use Exception;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Training\Entities\WorkGroup;
use Modules\Training\Repositories\Interfaces\WorkGroupRepositoryInterface;

class WorkGroupRepository extends ModelRepository implements WorkGroupRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'work_groups';


    /**
     * @var object
    */
    protected $model;

    public function __construct(
        WorkGroup $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Public function to retrieve the Work Groups
     *
     * @return Collection
     */

    public function findAllWorkGroupsByExerciseSession($exercise_session_id)
    {
        $relations = $this->getModelRelations();

        return $this->model
            ->where('exercise_session_id', $exercise_session_id)
            ->with($relations)
            ->get();
    }

    /**
     * Public function to retrieve the Work Group by Id
     *
     * @return Collection
     */

    public function findWorkGroupByCode($code)
    {
        $relations = $this->getModelRelations();

        return $this->model
            ->with($relations)
            ->where("code",$code)
            ->first();
    }

    /**
     * Public function to retrieve the Work Group by Id
     *
     * @return Collection
     */

    public function findWorkGroupByExercise($session_exercise_code)
    {
        $relations = $this->getModelRelations();

        return$this->model
            ->whereHas('exercise_session_exercise', function ($query) use($session_exercise_code){
                $query->where('exercise_session_exercises.code',$session_exercise_code);
            })
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
        return [
            'players' => function ($query)  {
                $query->select('players.id', 'players.full_name', 'players.image_id', 'players.gender_id')
                ->with(['image']);
            },
        ];
    }
}