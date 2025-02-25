<?php

namespace Modules\Training\Entities;

use Illuminate\Support\Str;
use Modules\Team\Entities\Team;
use Modules\Exercise\Entities\Exercise;
use Illuminate\Database\Eloquent\Model;
use Modules\Training\Entities\TargetSession;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\TrainingPeriod;
use Modules\Training\Entities\TypeExerciseSession;
use Modules\Training\Entities\ExerciseSessionDetails;
use Modules\Training\Entities\ExerciseSessionExercise; 


/**
 * @OA\Schema(
 *      title="ExerciseSession",
 *      description="ExerciseSession model",
 *      @OA\Xml( name="ExerciseSession"),
 *      @OA\Property( title="Author", property="author", description="who creates the session", format="double", example="6" ),
 *      @OA\Property( title="Title", property="title", description="session title", format="double", example="5" ),     
 *      @OA\Property( title="Icon", property="icon", description="identifier icon", format="double", example="5" ),     
 *      @OA\Property( title="Difficulty", property="difficulty", description="session difficulty", format="double", example="5" ),    
 *      @OA\Property( title="Intensity", property="intensity", description="session intensity", format="double", example="3" ),    
 *      @OA\Property( title="Duration", property="duration", description="session duration", format="integer", example="1" ),    
 *      @OA\Property( title="Number Exercises", property="number_exercises", description="number exercises", format="integer", example="1" ) ,   
 *      @OA\Property( title="Materials", property="materials", description="materials", format="integer", example="1" ) ,   
 *      @OA\Property( title="Type Exercise", property="type_exercise_session_id", description="Type Exercise", format="integer", example="1" )  ,  
 *      @OA\Property( title="Training Period", property="training_period_id", description="Training Period", format="integer", example="1" ),    
 *      @OA\Property( title="Team", property="team_id", description="team associate", format="integer", example="1" )    
 * * )
 */
class ExerciseSession extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author',
        'title',
        'icon',
        'difficulty',
        'intensity',
        'duration',
        'number_exercises',
        'materials',
        'type_exercise_session_id',
        'training_period_id',
        'entity_id',
        'entity_type',
        'order',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::uuid()->toString();
        });
    }

     /**
     * Returns the Type Exercise session object related to the  Exercise Session
     *
     * @return Array
     */
    public function type_exercise_session()
    {
        return $this->belongsTo(TypeExerciseSession::class);
    }

    /**
     * Returns the Training Period object related to the  Exercise Session
     *
     * @return Array
     */
    public function training_period()
    {
        return $this->belongsTo(TrainingPeriod::class);
    }

    /**
     * Returns a list of Exercise Session Details objects related to the Exercise Session
     *
     * @return Array
     */
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_session_exercises')
            ->withTimestamps();
    }

    /**
     * Returns a list of Exercise Session Details objects related to the Exercise Session
     *
     * @return Array
     */
    public function exercise_session_details()
    {
        return $this->HasMany(ExerciseSessionDetails::class);
    }

    /**
     * Returns a list of Exercise Session Details objects related to the Exercise Session
     *
     * @return Array
     */
    public function exercise_session_detail()
    {
        return $this->HasOne(ExerciseSessionDetails::class);
    }

    /**
     * Returns a list of Exercise Session Details objects related to the Exercise Session
     *
     * @return Array
     */
    public function exercise_session_exercises()
    {
        return $this->HasMany(ExerciseSessionExercise::class);
    }

     /**
     * Returns the Team object related to the Exercise Session
     *
     * @return Array
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Returns a list of targets objects related to the  Exercise Session
     *
     * @return Array
     */
    public function targets()
    {
        return $this->belongsToMany(TargetSession::class, 'exercise_session_target')
            ->withTimestamps();
    }

    /**
     * Returns a list of Exercise Session Like objects related to the Exercise Session
     *
     * @return Array
     */
    public function exercise_session_likes()
    {
        return $this->HasMany(ExerciseSessionLike::class);
    }

     /**
     * Returns a Exercise Session execution
     *
     * @return HasOne
     */
    public function exercise_session_execution()
    {
        return $this->HasOne(ExerciseSessionDetails::class);
    }

    /**
     * Get all of the models that own activities.
     *
     * @return array
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
