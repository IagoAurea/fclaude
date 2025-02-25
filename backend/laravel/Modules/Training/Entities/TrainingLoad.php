<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingLoad extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'training_loads';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'from',
        'to',
        'period',
        'value'
    ];

    /**
     * Get all of the models that own activities.
     *
     * @return array
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Returns a list of Exercise Session Assistance objects related to the training load
     *
     * @return Array
     */
    public function  exercise_session_assistance()
    {
        return $this->belongsToMany(ExerciseSessionAssistance::class, 'training_loads_exercise_session')
            ->withTimestamps();
    }
}
