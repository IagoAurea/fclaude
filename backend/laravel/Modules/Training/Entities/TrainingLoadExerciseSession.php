<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingLoadExerciseSession extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'training_loads_exercise_session';

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'training_load_id',
        'exercise_session_assistance_id'
    ];
}
