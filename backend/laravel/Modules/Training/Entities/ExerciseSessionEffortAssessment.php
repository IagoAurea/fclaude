<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\ExerciseSessionAssistance;
use Modules\Training\Entities\EffortAssessmentHeartRate;
use Modules\Training\Entities\EffortAssessmentGps;
use Modules\Training\Entities\SubjecPerceptEffort;

/**
 * @OA\Schema(
 *      title="ExerciseSessionEffortAssessment",
 *      description="ExerciseSessionEffortAssessment model",
 *      @OA\Xml( name="ExerciseSessionEffortAssessment"),
 *      @OA\Property( title="Assistance", property="assistance_id", description="assistanse associate", format="integer", example="1" ),
 *      @OA\Property( title="Subjetive Percept", property="subjec_percept_effort_id", description="perception of effort", format="integer", example="1" ),     
 *      @OA\Property( title="Hear Rate", property="effort_assessment_heart_rate_id", description="table hear rate associate", format="integer", example="1" ),     
 *      @OA\Property( title="Gps", property="effort_assessment_gps_id", description="table gps associate", format="integer", example="1" ),    
 * * )
 */
class ExerciseSessionEffortAssessment extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_session_effort_assessments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assistance_id',
        'subjec_percept_effort_id',
        'effort_assessment_heart_rate_id',
        'effort_assessment_gps_id',
   
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
     * Returns the Exercise session Assistance object related to the  Exercise Session Effort Assessment
     * 
     * @return Array
     */
    public function exercise_session_assistance () 
    {
        return $this->belongsTo(ExerciseSessionAssistance::class);
    }

    /**
     * Returns the Subjetive perception object related to the  Exercise Session Effort Assessment
     * 
     * @return Array
     */
    public function subjetive_perception_effort() 
    {
        return $this->belongsTo(SubjecPerceptEffort::class);
    }

    /**
     * Returns the Heart Rate object related to the  Exercise Session Effort Assessment
     * 
     * @return Array
     */
    public function effort_assessment_heart_rate () 
    {
        return $this->belongsTo(EffortAssessmentHeartRate::class);
    }

    /**
     * Returns the Gps object related to the  Exercise Session Effort Assessment
     * 
     * @return Array
     */
    public function effort_assessment_gps () 
    {
        return $this->belongsTo(EffortAssessmentGps::class);
    }
}
