<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Contracts\Translatable as ContractsTranslatable;

/**
 * @OA\Schema(
 *      title="Subject",
 *      description="The subjects of a school center",
 *      @OA\Xml( name="Subject"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 *      @OA\Property( title="Image", property="image", description="File containing the image" )
 * )
 */
class Subject extends Model implements ContractsTranslatable
{
    use Translatable;

    protected $table = 'classroom_subjects';

    protected $fillable = [
        'code',
        'image_id',
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
     * List of hidden properties of the model
     *
     * @var Array
     */
    protected $hidden = [
        'translations'
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'is_physical_education'
    ];

    /**
     * Returns the related image resource object
     *
     * @return Object
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the calculated age attribute
     */
    public function getIsPhysicalEducationAttribute()
    {
        return $this->code == 'physical_education';
    }

}
