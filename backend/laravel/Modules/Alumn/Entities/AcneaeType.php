<?php

namespace Modules\Alumn\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class AcneaeType extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acneae_types';

    /**
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];

    /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'subtypes'
    ];

    /**
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'tooltip'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns all related subtypes
     */
    public function subtypes()
    {
        return $this->hasMany(AcneaeSubtype::class);
    }
}
