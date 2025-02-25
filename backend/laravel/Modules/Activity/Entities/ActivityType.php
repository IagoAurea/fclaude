<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class ActivityType extends Model
{
    use Translatable;

    /**
     * Disabled timestamps for not inserting data
     *
     * @var String
     */
    public $timestamps = false;

    /**
     * Name of the model table
     *
     * @var String
     */
    protected $table = 'activity_type';

    /**
     * List of fillable properties of the model
     *
     * @var Array
     */
    protected $fillable = [
        'code',
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
     * The attributes that are mass assignable translation.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name'
    ];
}
