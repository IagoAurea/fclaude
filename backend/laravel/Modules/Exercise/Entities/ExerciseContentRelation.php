<?php

namespace Modules\Exercise\Entities;

use Illuminate\Database\Eloquent\Model;

class ExerciseContentRelation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercises_contents_relations';

    /**
     * Determines incrementing behavior on table insertions.
     *
     * @var bool
     */
    public $incrementing = false;


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exercise_id',
        'content_exercise_id',
    ];
}
