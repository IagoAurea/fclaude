<?php

namespace Modules\Training\Repositories;

use Exception;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Training\Entities\ExerciseSessionLike;
use Modules\Training\Repositories\Interfaces\ExerciseSessionLikeRepositoryInterface;


class ExerciseSessionLikeRepository extends ModelRepository implements ExerciseSessionLikeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'exercise_session_likes';

    /**
     * @var object
    */
    protected $model;

    /**
     * @var $exercisesSessionLikeRepository
    */
    protected $exercisesSessionLikeRepository;

    public function __construct(
        ExerciseSessionLike $model
    )
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    /**
     * Public function to find likes associated with a exercise session id
     * 
     * @return Object
     */

    public function findAllBySessionCode($exercise_session_code){

        $exercise_session_like = $this->model
            ->whereHas('exercise_session', function ($query) use($exercise_session_code){
                $query->where('code',$exercise_session_code);
            })
            ->with('exercise_session')
            ->get();
        
        return $exercise_session_like;

    }
    
    /**
     * Public function to retrieve All likes  by team sessions
     * 
     * @return Object
    */

    public function findAllByTeamId($team_id)
    {
        $exercise_session_likes = $this->model
            ->whereHas('exercise_session', function ($query) use($team_id){
                $query->where('team_id',$team_id);
            })
            ->with([
                'exercise_session' => function ($query)  use ($team_id)  {
                    $query->where('team_id',$team_id);
                },
            ])
            ->get();
        
        return $exercise_session_likes;
    }

}