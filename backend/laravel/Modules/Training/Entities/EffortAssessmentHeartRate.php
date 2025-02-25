<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\ExerciseSessionEffortAssessment;

/**
 * @OA\Schema(
 *      title="EffortAssessmentHeartRate",
 *      description="EffortAssessmentHeartRate model",
 *      @OA\Xml( name="EffortAssessmentHeartRate"),
 *      @OA\Property( title="Max heart Rate", property="max_heart_rate", description="Maximum heart rate", format="decimal", example="106.1" ),
 *      @OA\Property( title="Mean heart Rate",property="mean_heart_rate",description="Mean heart rate", format="decimal", example="80.3" ),     
 *      @OA\Property( title="Min heart Rate", property="min_heart_rate", description="Minimum heart rate", format="decimal", example="60.4" ),     
 *      @OA\Property( title="Variability Heart Rate", property="variability_heart_rate", description="Heart rate variability (HRV)", format="decimal", example="20" ),    
 *      @OA\Property( title="Vo2max", property="vo2max", description="vo2max", format="decimal", example="3.2" )
 * * )
 */
class EffortAssessmentHeartRate extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'effort_assessment_heart_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'max_heart_rate',
        'mean_heart_rate',
        'min_heart_rate',
        'variability_heart_rate',
        'vo2max'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

     /**
     *  Returns the Exercise Session Effort Assessment object related to the Effort Assessment Heart Rate
     *
     * @return Array
     */
    public function exercise_session_effort_assessmment()
    {
        return $this->hasOne(ExerciseSessionEffortAssessment::class);
    }
}