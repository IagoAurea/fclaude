<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\ExerciseSessionEffortAssessment;

/**
 * @OA\Schema(
 *      title="EffortAssessmentGps",
 *      description="EffortAssessmentGps model",
 *      @OA\Xml( name="EffortAssessmentGps"),
 *      @OA\Property( title="Total Distance Traveled", property="total_distance_traveled", description="total distance in meters", format="decimal", example="6.5" ),
 *      @OA\Property( title="Number sprintd", property="number_sprints", description="total number of sprints", format="integer", example="5" ),     
 *      @OA\Property( title="Distance sprint", property="distance_sprint", description="Distance sprint", format="decimal", example="5.2" ),     
 *      @OA\Property( title="Max Speed", property="max_speed", description="maximum speed reached", format="decimal", example="5.4" ),    
 *      @OA\Property( title="Metabolic Pontency", property="metabolic_potency", description="Metabolic Pontency", format="integer", example="3" ),    
 *      @OA\Property( title="High Speed Race", property="high_speed_race", description="Faster running speed", format="decimal", example="1.2" ),    
 *      @OA\Property( title="Slowdowns", property="slowdowns", description="total slowdowns", format="integer", example="1" ),   
 *      @OA\Property( title="Accelerations", property="accelerations", description="total accelerations", format="integer", example="1" )    
 * * )
 */
class EffortAssessmentGps extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'effort_assessment_gps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_distance_traveled',
        'number_sprints',
        'distance_sprint',
        'max_speed',
        'metabolic_potency',
        'high_speed_race',
        'slowdowns',
        'accelerations'
   
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
     * Returns the Exercise Session Effort Assessment object related to the Effort Assessment Gps
     * 
     * @return Array
     */
    public function exercise_session_effort_assessmment () 
    {
        return $this->hasOne(ExerciseSessionEffortAssessment::class);
    }

}
