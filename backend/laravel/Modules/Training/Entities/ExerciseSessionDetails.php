<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\ExerciseSession;
use Modules\Training\Entities\ExerciseSessionPlace;
use Modules\Training\Entities\ExerciseSessionAssistance;


/**
 * @OA\Schema(
 *      title="ExerciseSessionDetails",
 *      description="ExerciseSessionDetails model",
 *      @OA\Xml( name="ExerciseSessionDetails"),
 *      @OA\Property( title="Exercise Session", property="exercise_session_id", description="number of hours at repose", format="double", example="6" ),
 *      @OA\Property( title="Date", property="date_session", description="number of hours at", format="double", example="5" ),     
 *      @OA\Property( title="Hour", property="hour_session", description="number of hours at", format="double", example="5" ),     
 *      @OA\Property( title="Place", property="place_session", description="number of hours at", format="double", example="5" ),    
 *      @OA\Property( title="Observation", property="observation", description="number of hours at", format="double", example="3" ),    
 * * )
 */
class ExerciseSessionDetails extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_session_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exercise_session_id',
        'exercise_session_place_id',
        'date_session',
        'hour_session',
        'observation'
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
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'exercise_session_place'
    ];

     /**
     * Returns the Exercise session object related to the  Exercise Session Detail
     *
     * @return Array
     */
    public function exercise_session()
    {
        return $this->belongsTo(ExerciseSession::class);
    }

     /**
     * Returns the Exercise session object related to the  Exercise Session Detail
     *
     * @return Array
     */
    public function exercise_session_place()
    {
        return $this->belongsTo(ExerciseSessionPlace::class);
    }

    /**
     * Returns a list of Assistance objects related to the Exercise Session Detail
     *
     * @return Array
     */
    public function assistances()
    {
        return $this->HasMany(ExerciseSessionAssistance::class);
    }

}
