<?php

namespace Modules\Address\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Country;
use Modules\Generality\Entities\Province;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'street',
        'city',
        'postal_code',
        'mobile_phone',
        'phone',
        'country_id',
        'province_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
        'entity_type',
        'entity_id',
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'country',
        'province'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone' => 'array',
        'mobile_phone' => 'array',
    ];

    // -------- Relationships
    /**
     * Get all of the models that own activities.
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Returns the related country object
     *
     * @return Object
     */
    public function country()
    {
        return $this->belongsTo(Country::class)
            ->select('id')
            ->withTranslation(app()->getLocale());
    }

    /**
     * Returns the related province object
     *
     * @return Object
     */
    public function province()
    {
        return $this->belongsTo(Province::class)
            ->select('id')
            ->withTranslation(app()->getLocale());
    }
}
