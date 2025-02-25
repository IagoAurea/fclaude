<?php

namespace Modules\Training\Entities;

use Modules\Sport\Entities\Sport;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Exercise\Entities\ContentExercise;
use Modules\Training\Entities\SubContentSession;
use Modules\Training\Entities\ExerciseSessionDetails;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


/**
 * @OA\Schema(
 *      title="TargetSession",
 *      description="TargetSession model",
 *      @OA\Xml( name="TargetSession"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 *      @OA\Property( title="Content exercise", property="content_exercise_id", description="content associate", format="integer", example="1" ),
 *      @OA\Property( title="Sub Content exercise", property="sub_content_session_id", description="sub content associate", format="integer", example="1" ),
 *      @OA\Property( title="Sport", property="sport_id", description="Sport Associate", format="integer", example="1" ),
 * * )
 */
class TargetSession extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'target_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'content_exercise_id',
        'sub_content_session_id',
        'sport_id'
    ];

     /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'sub_content_session'
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
     * List of hidden properties of the model
     *
     * @var Array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Returns the Sub content object related to the  Target Session
     *
     * @return Array
     */
    public function content_exercise()
    {
        return $this->belongsTo(ContentExercise::class);
    }

    /**
     * Returns the Sub content object related to the  Target Session
     *
     * @return Array
     */
    public function sub_content_session()
    {
        return $this->belongsTo(SubContentSession::class, 'sub_content_session_id', 'id');
    }

    /**
     * Returns the Sport object related to the  Target Session
     *
     * @return Array
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }


    /**
     * Returns a list of Exercise Session Detail objects related to the  target
     *
     * @return Array
     */
    public function  exercise_session_details()
    {
        return $this->belongsToMany(ExerciseSessionDetails::class, 'exercise_session_detail_target')
            ->withTimestamps();
    }
}
