<?php

namespace Modules\Training\Repositories;

use Exception;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Training\Entities\ExerciseSessionEffortAssessment;
use Modules\Training\Repositories\Interfaces\ExerciseSessionEffortAssessmentRepositoryInterface;


class ExerciseSessionEffortAssessmentRepository extends ModelRepository implements ExerciseSessionEffortAssessmentRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'exercise_session_effort_assessments';


    /**
     * @var object
    */
    protected $model;

    /**
     * @var $exerciseSessionEffortAssessmentRepository
    */
    protected $exerciseSessionEffortAssessmentRepository;

    public function __construct(
        ExerciseSessionEffortAssessment $model
    )
    {
        $this->model = $model;
        parent::__construct($this->model);
    }


    /**
     * Public function to create EffortAssessment by assistance
     *
     * @return Object
     */

    public function createEffortAssessment($request)
    {
        DB::beginTransaction();
        try {

            $effortAssessment = New ExerciseSessionEffortAssessment;

            $hear_rate = $effortAssessment->effort_assessment_heart_rate()->create($request->hear_rates);
            $gps = $effortAssessment->effort_assessment_gps()->create($request->gps);

            $request['effort_assessment_heart_rate_id'] = $hear_rate->id;
            $request['effort_assessment_gps_id'] =  $gps->id;

            $effortAssessment = $this->create($request->except('hear_rates','gps'));
            

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
        return $effortAssessment;
    }
 

}