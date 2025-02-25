<?php

namespace Modules\Player\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @OA\Schema(
 *      title="Skills",
 *      description="Skills model",
 *      @OA\Xml( name="Skills"),
 *      @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
 *      @OA\Property( title="Image", property="image_id", description="image associate", format="file", example="" ),
 * )
 */
class Skills extends Model
{
    use Translatable;

    /**
      * The table associated with the model.
      *
      * @var string
      */
     protected $table = 'skills';
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
         'code',
         'image_id'
     ];
 
     /**
      * The attributes that are not visible.
      *
      * @var array
      */
     protected $hidden = [
         'translations'
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
     * Additional fields
     * @var array
     */
    protected $appends = [
        "image_url"
    ];

     /**
      * Indicates if the model should be timestamped.
      *
      * @var bool
      */
     public $timestamps = false;

    /**
     * Only url image
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->image->url ?? null;
    }

    /**
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

}
