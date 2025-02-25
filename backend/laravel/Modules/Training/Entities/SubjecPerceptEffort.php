<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;
use Modules\Training\Entities\ExerciseSessionEffortAssessment;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="SubjecPerceptEffort",
 *      description="SubjecPerceptEffort model",
 *      @OA\Xml( name="SubjecPerceptEffort"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 *      @OA\Property( title="Number", property="number", description="number identify", format="integer", example="1" ),
 * * )
 */
class SubjecPerceptEffort extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subjec_percept_efforts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'number',
        'image_id'
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
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

     /**
     * The attributes that must not be shown from querying.
     *
     * @var array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Get the image of the type spec.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     *  Returns the Exercise Session Effort Assessment object related to the Effort Assessment Heart Rate
     *
     * @return Array
     */
    public function exercise_session_effort_assessmment()
    {
        return $this->hasOne(ExerciseSessionEffortAssessment::class);
    }
}
