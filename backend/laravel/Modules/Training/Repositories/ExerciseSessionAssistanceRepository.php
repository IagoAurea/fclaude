<?php

namespace Modules\Training\Repositories;

use Exception;
use Modules\Alumn\Entities\Alumn;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Training\Entities\ExerciseSessionAssistance;
use Modules\Training\Repositories\Interfaces\ExerciseSessionAssistanceRepositoryInterface;

class ExerciseSessionAssistanceRepository extends ModelRepository implements
    ExerciseSessionAssistanceRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'exercise_session_assistances';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        ExerciseSessionAssistance $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieve all training by entity
     */
    public function findAllTraining($entity, $id, $start = null, $end = null)
    {
        $query = $this->model->with(['perception_effort', 'exercise_session.exercise_session_detail'])
            ->where('applicant_type', $entity)
            ->where('applicant_id', $id)
            ->where('assistance', 1);

            if (!is_null($start) && !is_null($end)) {
                $query = $query->with([
                    'exercise_session.exercise_session_detail' => function ($query) use ($start, $end) {
                        $query->where('date_session', '>=', $start)
                            ->where('date_session', '<=', $end);
                    }
                ]);
            }

            return $query->get();
    }

    /**
     * Public function to make the assistance to session
     *
     * @return Object
    */

    public function createAssistanceToExerciseSession($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request->assistances as $assistance) {
                $value = [];

                if (isset($assistance['player_id'])) {
                    $value['applicant_id'] = $assistance['player_id'];
                    $value['applicant_type'] = Player::class;
                } else {
                    $value['applicant_id'] = $assistance['alumn_id'];
                    $value['applicant_type'] = Alumn::class;
                }

                $value['exercise_session_id'] =  $request->exercise_session_id;
                
                $this->updateOrCreate($value, [
                    'assistance' => $assistance['assistance'],
                    'perception_effort_id' => $assistance['perception_effort_id']
                ]);
            }
            
            DB::commit();
            
            return true;
            
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}