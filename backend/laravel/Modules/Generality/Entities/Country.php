<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Country extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso2',
        'iso3',
        'phone_code',
        'currency',
        'emoji',
        'emoji_u',
        'belongs_ue'
    ];

    /**
     * Attributes that must not be returned
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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'iso2';
    }

    public function provinces()
    {
        return $this->hasMany(Province::class, 'country_id', 'id');
    }

    /**
     * Connect the country with taxes, Polymorphic relationships
     * @return Connection to taxes
     */
    public function taxes(){
        return $this->morphMany(Tax::class, 'taxable');
    }

}
