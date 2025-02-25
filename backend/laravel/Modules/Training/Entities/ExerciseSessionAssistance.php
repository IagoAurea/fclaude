<?php

namespace Modules\Training\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Training\Entities\ExerciseSessionDetails;
use Modules\Training\Entities\ExerciseSessionEffortAssessment;
use Modules\Training\Services\ExerciseSessionAssistanceService;

/**
 * @OA\Schema(
 *      title="ExerciseSessionAssistance",
 *      description="ExerciseSessionAssistance model",
 *      @OA\Xml( name="ExerciseSessionAssistance"),
 *      @OA\Property( title="Assistance", property="assistance", description="if you attend the session", format="boolean", example="true" ),
 *      @OA\Property( title="Session Detail", property="exercise_session_detail_id", description="exercise session", format="integer", example="1" ),     
 * )
 */
class ExerciseSessionAssistance extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_session_assistances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assistance',
        'applicant_id',
        'applicant_type',
        'exercise_session_id',
        'perception_effort_id',
        'time_training',
        'training_load'
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
            $model->time_training = $model->exercise_session->duration;

            if ($model->perception_effort_id) {
                $model->training_load = $model->calculateTrainingLoadIndividual($model);
                $model->calculateTrainingLoad($model);
            }
        });

        static::updating(function ($model) {
            $model->time_training = $model->exercise_session->duration;

            if ($model->perception_effort_id) {
                $model->training_load = $model->calculateTrainingLoadIndividual($model);
                $model->calculateTrainingLoad($model);
            }
        });
    }

    /**
     * Calculate training load
    */
    private function calculateTrainingLoadIndividual($training)
    {
        return intval($training->time_training) * $training->perception_effort->number;
    }

     /**
     * Calculate trainig load entity by period
     *
     * @param @model
     */
    private function calculateTrainingLoad($model)
    {
        $exerciseSessionService = resolve(ExerciseSessionAssistanceService::class);

        $startOfWeek = Carbon::parse(
            // $model->exercise_session->exercise_session_detail->date_session //Date detail exercise sesion
            $model->updated_at
        )->startOfWeek();
        $endOfWeek = Carbon::parse(
            // $model->exercise_session->exercise_session_detail->date_session
            $model->updated_at
        )->endOfWeek();

        return $exerciseSessionService
            ->calculateTrainingLoad($model->applicant_type, $model->applicant_id, $startOfWeek, $endOfWeek);
    }

    /**
     * Returns the Exercise session Assistance object related to the  Exercise Session
     *
     * @return Array
     */
    public function exercise_session()
    {
        return $this->belongsTo(ExerciseSession::class);
    }

    /**
     * Returns the Subjetive perception object related to the  Exercise Session Effort Assessment
     *
     * @return Array
     */
    public function perception_effort()
    {
        return $this->belongsTo(SubjecPerceptEffort::class);
    }

    /**
     * Returns the Exercise session Assistance object related to the  Exercise Session Detail
     *
     * @return Array
     */
    public function exercise_session_detail()
    {
        return $this->belongsTo(ExerciseSessionDetails::class);
    }

    /**
     * Returns the Exercise session Assistance object related to the  Exercise Session Detail
     *
     * @return Array
     */
    public function exercise_session_effort_assessment()
    {
        return $this->hasOne(ExerciseSessionEffortAssessment::class);
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
