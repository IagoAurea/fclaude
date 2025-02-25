<?php

namespace Modules\Training\Entities;

use Illuminate\Support\Str;
use Modules\Exercise\Entities\Exercise;
use Illuminate\Database\Eloquent\Model;
use Modules\Training\Entities\WorkGroup;
use Modules\Training\Entities\ExerciseSession;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="ExerciseSessionExercise",
 *      description="ExerciseSessionExercise model",
 *      @OA\Xml( name="ExerciseSessionExercise"),
 *      @OA\Property( title="Duration", property="duration", description="session duration", format="string", example="6:00" ),
 *      @OA\Property( title="Repetitions", property="repetitions", description="Number repetitions", format="integer", example="1" ),     
 *      @OA\Property( title="Duration Repetitions", property="duration_repetitions", description="repetition duration", format="string", example="5:00" ),     
 *      @OA\Property( title="Break Repetitions", property="break_repetitions", description="rest reps", format="string", example="5:00" ),    
 *      @OA\Property( title="Series", property="series", description="number series", format="integer", example="1" ),    
 *      @OA\Property( title="Break Series", property="break_series", description="rest series", format="string", example="05:00" ),    
 *      @OA\Property( title="Exercise Session", property="exercise_session_id", description="exercise session associate", format="integer", example="1" ),    
 *      @OA\Property( title="Exercise", property="exercise_id", description="exercise associate", format="integer", example="1" )    
 * * )
 */
class ExerciseSessionExercise extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_session_exercises';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'duration',
        'repetitions',
        'duration_repetitions',
        'break_repetitions',
        'series',
        'break_series',
        'difficulty',
        'intensity',
        'exercise_session_id',
        'exercise_id',
        'order'
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
     * Returns a list of work groups objects related to the  Exercise Session exercise
     *
     * @return Array
     */
    public function work_groups()
    {
        return $this->belongsToMany(WorkGroup::class, 'exercise_session_exercise_work_group')
            ->withTimestamps();
    }

    /**
     * Returns a list of work groups objects related to the  Exercise Session exercise
     *
     * @return Array
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Returns a exercise session objects related to the  Exercise Session exercise
     *
     * @return Array
     */
    public function exercise_session()
    {
        return $this->belongsTo(ExerciseSession::class);
    }

}
