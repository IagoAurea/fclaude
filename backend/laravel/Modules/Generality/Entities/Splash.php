<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Splash extends Model implements TranslatableContract
{
    use Translatable;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'splashs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id',
        'active',
        'external',
        'url'
    ];

    /**
     * The attributes that must not be shown.
     *
     * @var array
     */
    protected $hidden = [
        'translations',
        'created_at',
        'updated_at',
        'active'
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
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with image
     * @return BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
