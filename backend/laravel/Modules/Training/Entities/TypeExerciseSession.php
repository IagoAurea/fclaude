<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Training\Entities\ExerciseSession;

/**
 * @OA\Schema(
 *      title="TypeExerciseSession",
 *      description="TypeExerciseSession model",
 *      @OA\Xml( name="TypeExerciseSession"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 * * )
 */
class TypeExerciseSession extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_exercise_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns a list of Exercise Session objects related to the Type Exercise
     *
     * @return Array
     */
    public function exercise_sessions()
    {
        return $this->HasMany(ExerciseSession::class);
    }
}
