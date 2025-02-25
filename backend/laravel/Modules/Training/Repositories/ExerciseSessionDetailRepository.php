<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\ExerciseSessionDetails;
use Modules\Training\Repositories\Interfaces\ExerciseSessionDetailRepositoryInterface;

class ExerciseSessionDetailRepository extends ModelRepository implements ExerciseSessionDetailRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'exercise_session_details';


    /**
     * @var object
    */
    protected $model;

    public function __construct(
        ExerciseSessionDetails $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Public function to find executions associated with a exercise session id
     * 
     * @return Object
     */

    public function findAllBySessionCode($session_code){

        $exercise_session_detail = $this->model
            ->whereHas('exercise_session', function ($query) use($session_code){
                $query->where('code',$session_code);
            })
            ->with('exercise_session');
        
        return $exercise_session_detail->get();

    }

    /**
     * Public function to find executions associated with a team
     * 
     * @return Object
     */

    public function findAllByTeamId($team_id){

        $exercise_session_detail = $this->model
            ->whereHas('exercise_session', function ($query) use($team_id){
                $query->where('team_id',$team_id);
            })
            ->with([
                'exercise_session' => function ($query)  use ($team_id)  {
                    $query->where('team_id',$team_id);
                },
            ])
            ->orderBy('exercise_session_details.date_session','ASC');
            
        return $exercise_session_detail->get();
    }
}