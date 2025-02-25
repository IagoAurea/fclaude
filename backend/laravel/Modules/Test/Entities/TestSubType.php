<?php

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\Generality\Entities\Resource;

/**
 * @OA\Schema(
 *      title="TestSubType",
 *      description="TestSubType model",
 *      @OA\Xml( name="TestSubType"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="type_test" ),
 * )
 */
class TestSubType extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_sub_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'test_type_id',
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
}

