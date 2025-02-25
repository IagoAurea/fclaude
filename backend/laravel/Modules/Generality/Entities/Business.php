<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cif',
        'address',
        'code_postal',
        'phone',
        'city',
        'country_id',
        'image_id'
    ];

    /**
     * The relationships to be inlcuded
     *
     * @var array
     */
    protected $with = [
        'image',
        'country'
    ];

    /**
     * Foreign key with countries
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Foreign key with resources
     * @return BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Resource::class, 'image_id', 'id');
    }
}
