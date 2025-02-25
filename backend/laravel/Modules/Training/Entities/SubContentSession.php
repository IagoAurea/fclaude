<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Training\Entities\TargetSession;
use Modules\Team\Entities\ContentExercise;

/**
 * @OA\Schema(
 *      title="SubContentSession",
 *      description="SubContentSession model",
 *      @OA\Xml( name="SubContentSession"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 *      @OA\Property( title="Content exercise", property="content_exercise_id", description="content associate", format="integer", example="1" ),
 * * )
 */
class SubContentSession extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sub_content_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'content_exercise_id'
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
     * Items that must not be showable from querying
     * @var array
     */
    protected $hidden = [
        'translations',
    ];

    /**
     * Returns a list of Target session objects related to the Sub Content
     *
     * @return Array
     */
    public function target_sessions()
    {
        return $this->HasMany(TargetSession::class);
    }
    
    /**
     * Returns a list of Target session objects related to the Sub Content
     *
     * @return Array
     */
    public function targets()
    {
        return $this->HasMany(TargetSession::class);
    }

    /**
     * Returns a content objects related to the Sub Content
     *
     * @return Array
     */
    public function content_exercise()
    {
        return $this->belongsTo(ContentExercise::class);
    }

    
}
