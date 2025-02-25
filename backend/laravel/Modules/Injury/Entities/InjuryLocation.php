<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Modules\Generality\Entities\Resource;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class InjuryLocation extends Model implements TranslatableContract
{
    use Translatable;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_locations';

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
        'translations',
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
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
