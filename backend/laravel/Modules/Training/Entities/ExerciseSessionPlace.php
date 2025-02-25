<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class ExerciseSessionPlace extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_session_places';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_session',
        'entity_id',
        'entity_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];


}
