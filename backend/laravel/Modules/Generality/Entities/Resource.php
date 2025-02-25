<?php

namespace Modules\Generality\Entities;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resources';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'mime_type',
        'size'
    ];


    /**
     * Attributes that must not be returned on relationship instances
     * 
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'size',
        'mime_type',
        'url'
    ];

    /**
    * The attributes appended attributes that shall be shown
    *
    * @var array
    */
    protected $appends = [
        'full_url'
    ];

    /**
     * The virtual attribute that return url full of resource.
     *
     * @return string
     */
    public function getFullUrlAttribute()
    {
        return config('resource.url') .'/'. $this->url;
    }
} 
