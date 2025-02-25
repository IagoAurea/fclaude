<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;


/**
 * @OA\Schema(
 *      title="TestType",
 *      description="TestType model",
 *      @OA\Xml( name="TestType"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
 * )
 */
class TestType extends Model implements TranslatableContract
{
    use Translatable;

    const CLASSIFICATION_RFD = 1;
    const CLASSIFICATION_TEST = 2;
    const CLASSIFICATION_BOTH = 3;
    const CLASSIFICATION_FISIOTHERAPY = 4;
    const CLASSIFICATION_EXERCISE_SESSION = 5;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'classification',
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
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

    /**
     * Additional fields
     * @var array
     */
    protected $appends = [
    ];
    
     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the relations with sub types.
     */
    public function subTypes()
    {
        return $this->HasMany(TestSubType::class);
    }
}
