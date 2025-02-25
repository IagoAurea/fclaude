<?php

namespace Modules\Exercise\Entities;

use Illuminate\Database\Eloquent\Model;

class ExerciseEntity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_entities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'exercise_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Allways show this relationships
     * 
     * @var array
     */
    protected $with = [
        // 'exercise'
    ];

    /**
     * Get the relational entity
     * 
     * @return Array|Object
     */
    public function exercise()
    {
        return $this->BelongsTo(Exercise::class);
    }

}
