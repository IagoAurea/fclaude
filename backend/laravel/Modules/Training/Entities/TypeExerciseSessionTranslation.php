<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      title="TypeExerciseSessionTranslation",
 *      description="TypeExerciseSessionTranslation model",
 *      @OA\Xml( name="TypeExerciseSessionTranslation"),
 *      @OA\Property( title="Locale", property="locale", description="translation language", format="string", example="en" ),
 *      @OA\Property( title="Type Exercise Session", property="type_exercise_session_id", description="entity id", format="integer", example="1" ),
 *      @OA\Property( title="Name", property="name", description="translated name", format="string", example="Target" )
 * * )
 */
class TypeExerciseSessionTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_exercise_session_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
